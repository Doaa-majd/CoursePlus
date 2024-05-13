<?php

declare(strict_types=1);

namespace App\Services\Carts;

use App\Models\Cart;
use App\Models\User;
use App\Services\Carts\PayPalBuyService;

class CheckoutService
{
    protected $payPalBuyService;

    public function __construct(PayPalBuyService $payPalBuyService)
    {
        $this->payPalBuyService = $payPalBuyService;
    }

    public function index()
    {
        $userId =  \Auth::id();

        return [
            'user' => User::with('profile')->where('id', $userId)->first(),
            'cart' => Cart::with('course')->where('user_id', $userId)->get()
        ];
    }

    public function store()
    {
        $userId = \Auth::id();
        $cart = Cart::where('user_id', $userId)->get();

        \DB::beginTransaction();
        try {
            $order = Order::create([
                        'user_id' => $userId,
                        'status' => Order::PENDING,
                    ]);

            $total = 0;
            foreach ($cart as $item) {
                $total += $item->price;
            }
            $returnName = 'checkout';
            DB::commit();

            return $this->payPalBuyService->paypal($order, $total, $returnName);
            return $order;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

}