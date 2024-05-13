<?php

declare(strict_types=1);

namespace App\Services\Carts;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Models\Course;
use App\Models\Setting;
use App\Models\CourseUser;
use App\Models\CourseOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use App\Services\Permissions\PermissionService;

class PayPalBuyService
{
    public const CHECKOUT = 'checkout';
    public const USD = 'USD';

    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    protected function paypal(Order $order, $total, $returnName)
    {
        $client = $this->payaplClient();
        $request = $this->payPalRequest($order, $total, $returnName);
        try {
            $response = $client->execute($request);
            if ($response->statusCode == 201) {
                session()->put('paypal_order_id', $response->result->id);
                session()->put('order_id', $order->id);

                foreach ($response->result->links as $link) {
                    if ($link->rel == 'approve') {
                        return redirect()->away($link->href);
                    }
                }
            }
        } catch (Throwable $e) {
            return $e->getMessage();
        }
        return 'Unknown Error! ' . $response->statusCode;
    }

    private function payPalRequest($order, $total, $returnName)
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
                            "intent" => "CAPTURE",
                            "purchase_units" => [[
                                "reference_id" => $order->id,
                                "amount" => [
                                    "value" => $total,
                                    "currency_code" => self::USD
                                ]
                            ]],
                            "application_context" => [
                                "cancel_url" => url(route('paypal.delete')),
                                "return_url" => $returnName == self::CHECKOUT ?
                                    url(route('paypal.return')) :
                                    url(route('paypal.buynow.return'))
                            ]
                        ];
        return $request;
    }

    private function payaplClient()
    {
        $config = config('services.paypal');
        $env = new SandboxEnvironment($config['client_id'], $config['client_secret']);
        $client = new PayPalHttpClient($env);

        return $client;
    }

    public function return()
    {
        $paypalOrderId = session()->get('paypal_order_id');
        $request = new OrdersCaptureRequest($paypalOrderId);
        $request->prefer('return=representation');
        $isResponse = false;
        try {
            $response = $this->payaplClient()->execute($request);

            if ($response->statusCode == 201) {
                if (strtoupper($response->result->status) == 'COMPLETED') {
                    $this->processCartOrder();
                    $isResponse = true;
                }
            }
            return $isResponse;
        } catch (Throwable $e) {
            return $e->getMessage();
        }
    }

    private function processCartOrder()
    {
        $orderId = session()->get('order_id');
        DB::beginTransaction();
        try {
            $order = Order::findOrFail($orderId);
            $order->status = Order::COMPLETED;
            $order->save();

            $cart = Cart::where('user_id', Auth::id())->get();
            $commission = $this->getCommission();

            foreach ($cart as $item) {
                $discount = ($item->price * $commission) / 100 ; // this discount for admin --to calc site profit later
                $priceAfterCommission = $item->price - $discount ; // this the price after subtrac the discount --profit for instructor 

                CourseOrder::create([
                    'order_id' => $order->id,
                    'course_id' => $item->course_id,
                    'price' => $item->price,
                    'price_after_discount' => $priceAfterCommission,
                    'discount' => $discount
                ]);
                $this->registerCourse($item->course_id);
            }
            session()->forget(['order_id', 'paypal_order_id']);

            Cart::where('user_id', Auth::id())->delete();
            DB::commit();
            Cookie::queue(Cookie::make('cart_id', '', -60));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function buynowReturn()
    {
        $paypal_order_id = session()->get('paypal_order_id');
        $request = new OrdersCaptureRequest($paypal_order_id);
        $request->prefer('return=representation');
        $isResponse = false;
        try {
            $response = $this->payaplClient()->execute($request);

            if ($response->statusCode == 201) {
                if (strtoupper($response->result->status) == 'COMPLETED') {
                    $this->processCourseOrder();
                    $isResponse = true;
                }
            }
            return $isResponse;
        } catch (Throwable $e) {
            return $e->getMessage();
        }
    }

    private function processCourseOrder()
    {
        $orderId = session()->get('order_id');

        DB::beginTransaction();
        try {
            $order = Order::findOrFail($orderId);
            $order->status = Order::COMPLETED;
            $order->save();

            $courseId = session()->get('course_id');
            $course = Course::findOrFail($courseId);

            $commission = $this->getCommission();
            $discount = ($course->price * $commission) / 100 ; // this discount for admin --to calc site profit later
            $priceAfterCommission = $course->price - $discount ; // this the price after subtrac the discount --profit for instructor 

            CourseOrder::create([
                'order_id' => $order->id,
                'course_id' => $course->id,
                'price' => $course->price,
                'price_after_discount' => $priceAfterCommission,
                'discount' => $discount
            ]);

            DB::commit();
            session()->forget(['order_id', 'paypal_order_id']);
            $this->registerCourse($course_id);

            //event(new OrderCompleted());
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function getCommission()
    {
        $commission = Setting::where('name', 'commission')->first()->value ;
        return number_format((double)$commission, 2, '.', '');
    }

    public function registerCourse($courseId)
    {
        $userId = Auth::id();
        DB::beginTransaction();
        try {
            $courseUser = CourseUser::create([
                'user_id' => $userId,
                'course_id' => $courseId,
            ]);
            $this->fireCourseEvent($courseUser);
            $this->permissionService->giveStudenPermissions($userId);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    private function fireCourseEvent($courseUser)
    {
        $instructorId = CourseUser::where('course_id', $courseUser->course_id)->
        where('user_status', 'instructor')->
        first()->user_id;
        // event(new CourseEnroll($instructorId)); 
    }

    public function cancel()
    {
        $id = session()->get('order_id');
        $order = Order::findOrFail($id);
        $order->status = Order::CANCELLED;
        $order->save();
    }

}