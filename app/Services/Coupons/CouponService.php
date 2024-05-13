<?php

declare(strict_types=1);

namespace App\Services\Coupons;

use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\User;
use App\Models\CourseCoupon;
use Carbon\Carbon;

class CouponService
{

    public function getCoupons()
    {
        if (\Auth::user()->role == User::ADMIN) {
            return Coupon::orderBy('created_at', 'desc')->paginate(6);
        }

        if (\Auth::user()->role == User::INSTRUCTOR) {
            return Coupon::where('user_instructor_id', \Auth::id())->orderBy('created_at', 'desc')->paginate(6);
        }
    }

    public function store($data)
    {
        $coupon = Coupon::create([
            'code' => $data['code'],
            'type' => $data['type'],
            'value' => $data['value'],
            'max_usage' => $data['max_usage'],
            'expired_date' => $data['expired_date'],
            'user_instructor_id' => \Auth::id()
        ]);
        foreach ($data['courses'] as $course) {
            CourseCoupon::create([
                'course_id' => $course,
                'coupon_id' => $coupon->id
            ]);
        }
    }

    public function update($data, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update([
            'code' => $data['code'],
            'type' => $data['type'],
            'value' => $data['value'],
            'max_usage' => $data['max_usage'],
            'expired_date' => $data['expired_date'],
        ]);
        $coupon->courses()->sync($data['courses']);
    }

    public function couponApply($data)
    {
        $price = 0;
        $coupon = Coupon::where('code', $data['code'])->first();

        $this->checkCouponValid($coupon, $data['course_id']);

        if ($coupon->type == Coupon::PERCENTAGETYPE) {
            $price = $data['price'] - ($coupon->value * $data['price'] / 100);
        }
        if ($coupon->type == Coupon::FIXEDTYPE) {
            $price = $data['price'] - $coupon->value;
        }
        CouponUser::create([
            'user_id' => \Auth::id(),
            'coupon_id' => $coupon->id,
            'course_id' => $data['course_id'],
            'price_after_coupon' => $price
        ]);
        return $price;
    }

    private function checkCouponValid($coupon, $courseId)
    {
        if (!$coupon || $coupon->expired_date < Carbon::now()) {
            throw new \Exception('This coupon is expired');
        }

        $numberOfUsage = CouponUser::where('coupon_id', $coupon->id)->count();
        if ($coupon->max_usage < $numberOfUsage) {
            throw new \Exception('Coupon exceed the max usage');
        }

        $courseCoupon = CourseCoupon::where('coupon_id', $coupon->id)->where('course_id', $courseId)->first();
        if (!$courseCoupon) {
            throw new \Exception('Can not apply coupon for this course');
        }
    }

    public function deleteCouponUser($data)
    {
        $coupon = Coupon::where('code', $data['code'])->first();
        CouponUser::where('coupon_id', $coupon->id)->where('user_id', \Auth::id())->delete();
    }

    public function getCouponIfApplied($courseId)
    {
        $couponUser = CouponUser::with('coupon')->where('course_id', $courseId)->where('user_id', \Auth::id())->first();

        if ($couponUser) {
            return [
                'is_coupon_applied' => true,
                'price' => $couponUser->price_after_coupon,
                'code' => $couponUser->coupon->code
            ];
        } else {
            return [
                'is_coupon_applied' => false
            ];
        }
    }
}
