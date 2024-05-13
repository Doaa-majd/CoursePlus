<?php

namespace App\Http\Controllers\Web\Carts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\web\Carts\CouponApplyRequest;
use App\Http\Requests\web\Carts\CouponDeleteRequest;
use App\Services\Coupons\CouponService;

class CouponController extends Controller
{
    protected $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    public function apply(CouponApplyRequest $request)
    {
        $data = $request->validated();
        $price = $this->couponService->couponApply($data);
        return response()->json(['success' => $price]);
    }

    public function delete(CouponDeleteRequest $request)
    {
        $data = $request->validated();
        $price = $this->couponService->deleteCouponUser($data);
        return response()->json(['success' => 'deleted successfully']);
    }
}
