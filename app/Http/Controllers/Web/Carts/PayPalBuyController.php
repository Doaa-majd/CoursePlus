<?php

namespace App\Http\Controllers\Web\Carts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Carts\PayPalBuyService;

class PayPalBuyController extends Controller
{
    protected $payPalBuyService;

    public function __construct(PayPalBuyService $payPalBuyService)
    {
        $this->payPalBuyService = $payPalBuyService;
    }

    public function return()
    {
        if ($this->payPalBuyService->return()) {
            return redirect()->route('user.courses.show', [$course_id]);
        } else {
            return redirect()->route('user.courses.index');
        }
    }

    public function buyNowReturn()
    {
        if ($this->payPalBuyService->buynowReturn()) {
            return redirect()->route('user.courses.show', [$course_id]);
        } else {
            return redirect()->route('user.courses.index');
        }
    }

    public function delete()
    {
        $this->payPalBuyService->cancel();
        return redirect()->route('user.courses.index');
    }
}
