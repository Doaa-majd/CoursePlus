<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Coupons\CouponService;
use Illuminate\Support\Str;
use App\Http\Requests\web\Admin\CouponStoreRequest;
use App\Http\Requests\Web\Admin\CouponUpdateRequest;
use App\Models\Coupon;
use App\Services\Courses\CourseService;

class CouponController extends Controller
{
    protected $couponService;
    protected $courseService;

    public function __construct(CouponService $couponService, CourseService $courseService)
    {
        $this->couponService = $couponService;
        $this->courseService = $courseService;
    }

    public function index()
    {
        $coupons = $this->couponService->getCoupons();
        return view('admin.coupons.index', [
            'coupons' => $coupons,
        ]);
    }

    public function create()
    {
        $courses = $this->courseService->getCoursesByUserType();
        return view('admin.coupons.create', [
            'courses' => $courses
        ]);
    }

    public function store(CouponStoreRequest $request)
    {
        $data = $request->validated();
        $this->couponService->store($data);
        return redirect()->back()->with('alert.success', "Coupon created");
    }

    public function edit(Coupon $coupon)
    {
        $courses = $this->courseService->getCoursesByUserType();
        return view('admin.coupons.edit', [
            'coupon' => $coupon,
            'courses' => $courses
        ]);
    }

    public function update(CouponUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $this->couponService->update($data, $id);

        return redirect()->back()->with('alert.success', "Coupon updated");
    }

    public function delete(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->back()->with('alert.success', "Coupon deleted");
    }

    public function generate()
    {
        $code = strtoupper(Str::random(6));
        return response()->json(['success' => "generated successfully.", 'code' => $code]);
    }
}
