<?php

namespace App\Http\Controllers\Web\Carts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Carts\PayPalPayoutService;
use App\Models\CourseUser;
use App\Models\User;
use App\Http\Requests\Web\Carts\PayPalPayoutStoreRequest;

class PayPalPayoutController extends Controller
{
    protected $payPalPayoutService;

    public function __construct(PayPalPayoutService $payPalPayoutService)
    {
        $this->payPalPayoutService = $payPalPayoutService;
    }

    public function index()
    {
        $result = $this->payPalPayoutService->getEarning();
        return view('admin.payout', $result);
    }

    public function store(PayPalPayoutStoreRequest $request)
    {
        $data = $request->validated();
        $result = $this->payPalPayoutService->withdraw($data);
        return response()->json(['success' => __('You withdraw successfully')]);
    }
}
