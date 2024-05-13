<?php

namespace App\Http\Controllers\Web\Carts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Carts\CheckoutService;

class CheckoutController extends Controller
{
    protected $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function index()
    {
        $result = $this->checkoutService->index();
        return view('checkout', $result);
    }

    public function store()
    {
        $order = $this->checkoutService->store();
        return redirect()
            ->route('user.courses.index')
            ->with('success', __('Order #:id created and completed', ['id' => $order->id]));
    }
}
