<?php

declare(strict_types=1);

namespace App\Services\Carts;

use App\Models\User;
use App\Models\CourseUser;
use App\Models\Transaction;
use App\Models\CourseOrder;
use Illuminate\Support\Arr;

class PayPalPayoutService
{
    private function getcoursesWithCourseOrder()
    {
        $payout = [];
        $totalEarning = 0 ;

        $coursesUser = CourseUser::with('course.coursesOrder')->
            where('user_id', \Auth::id())->
            where('user_status', User::INSTRUCTOR)
            ->get();
        foreach ($coursesUser as $key => $courseUser) {
            $payout[$key]['id'] = $courseUser->course_id;
            $payout[$key]['name'] = $courseUser->course->title;

            $corseOrder = $this->getCourseOrderData($courseUser->course->coursesOrder);

            $payout[$key]['price'] = $corseOrder['price'];
            $payout[$key]['sales_number'] = $corseOrder['sales_number'];
            $payout[$key]['total_price_after_commission'] = $corseOrder['total_price_after_commission'];
            $totalEarning = $totalEarning + $payout[$key]['total_price_after_commission'];
        }
        return [
            'payouts' => $payout,
            'total_earning' => $totalEarning
        ];
    }

    public function getEarning()
    {
        $payout = $this->getcoursesWithCourseOrder();
        $adminCommissions = 0;
        $adminTotalEarning = 0;
        $isAdmin = \Auth::user()->role == User::ADMIN;
        if ($isAdmin) {
            $adminCommissions = (double)CourseOrder::sum('discount');
            $adminTotalEarning =  $adminCommissions + $payout['total_earning'];
        }
        $currentEarning = 0;
        $remain = Transaction::where('user_id', \Auth::id())->orderBy('created_at', 'desc')->first();
        $currentEarning = $remain ? $remain->amount : ($isAdmin ? $adminTotalEarning : $payout['total_earning']);

        return [
            'payouts' => $payout['payouts'],
            'total_earning' => $payout['total_earning'],
            'admin_commission' => $adminCommissions,
            'admin_total' => $adminTotalEarning,
            'current_earning' => $currentEarning
        ];
    }

    private function getCourseOrderData($courseOrders)
    {
        $salesNumber = 0;
        $price = 0;
        $totalPriceAfterCommission = 0;
        if (!empty($courseOrders)) {
            foreach ($courseOrders as $index => $order) {
                $totalPriceAfterCommission = (double)$totalPriceAfterCommission + (double)$order->price_after_discount;
                $price = $price + $order->price; // calc total price of all orders of each course -- without commission
                $salesNumber = $index + 1;
            }
        }
        return [
            'total_price_after_commission' => $totalPriceAfterCommission,
            'price' => $price,
            'sales_number' => $salesNumber
        ];
    }

    public function withdraw(array $data)
    {
        $amount = (double)$data['amount'];
        $total =  $this->getTotalAmount();
        if ($amount > $total) {
            throw new \Exception('Your payout is larger than your profit');
        }
        $this->createPayout($amount, $total, $data['email']);
    }

    private function createPayout($amount, $total, $email, $debug = false)
    {
        $request = new PayoutsPostRequest();
        $request->body = $this->buildRequestBody($amount, $email);
        $client =  $this->payaplClient();
        $response = $client->execute($request);

        if ($response->statusCode == 201) {
            if (strtoupper($response->result->batch_header->batch_status) == 'PENDING') {
                $remain = $total - $amount ;
                $transaction = Transaction::create([
                    'user_id' => \Auth::id(),
                    'amount' => $amount,
                    'price_after_process' => $remain,
                    'status' => Transaction::WITHDRAW
                ]);
            }
        }
        throw new \Exception('Can not complete the payout process');
    }

    private function buildRequestBody($amount, $email)
    {
        return json_decode(
            '{
                "sender_batch_header":
                {
                  "email_subject": "payouts process"
                },
                "items": [
                {
                  "recipient_type": "EMAIL",
                  "receiver": "' . $email . '",
                  "note": "Your 1$ payout",
                  "sender_item_id": "Test_txn_12",
                  "amount":
                  {
                    "currency": "USD",
                    "value": "' . $amount . '"
                  }
                }]
              }',
            true
        );
    }

    private function payaplClient()
    {
        $config = config('services.paypal');
        $environment = new SandboxEnvironment($config['client_id'], $config['client_secret']);
        $client = new PayPalHttpClient($environment);
        return $client;
    }

    private function getTotalAmount()
    {
        $adminAmount = 0;
        $instructorAmount = 0;

        $userId = \Auth::id();
        $isAdmin = \Auth::user()->role == User::ADMIN;

        $totalAmount = $this->getAdminProfit() + $this->getInstructorsProfit($userId);
        $instructorAmount = $this->getInstructorsProfit($userId);

        $currentEarning = 0;
        $remain = Transaction::where('user_id', $userId)->orderBy('created_at', 'desc')->first();
        return $currentEarning = $remain ? $remain->total_price : ($isAdmin ? $totalAmount : $instructorAmount);
    }

    public function getAdminProfit()
    {
        return (double)CourseOrder::sum('discount');
    }

    public function getInstructorsProfit($userId)
    {
        $result = \DB::table('course_orders')->select(\DB::raw('sum(price_after_discount) as total'))
                  ->wherein('course_id', function ($query) use ($userId) {
                        $query->selectRaw('course_id')
                        ->from('course_users')
                        ->where('user_id', $userId)
                        ->where('user_status', User::INSTRUCTOR);
                  })->get();
        return Arr::first($result)->total;
    }
}