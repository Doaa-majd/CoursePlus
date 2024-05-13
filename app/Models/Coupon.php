<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const FIXEDTYPE = 'fixed';
    public const PERCENTAGETYPE = 'percentage';

    public function courseCoupon()
    {
        return $this->hasMany(CourseCoupon::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_coupons');
    }

    public function couponInstructorUser()
    {
        return $this->hasMany(CouponInustrctorUser::class);
    }
}
