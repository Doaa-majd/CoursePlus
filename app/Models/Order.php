<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const PENDING = 'pending';
    public const CANCELLED = 'cancelled';
    public const COMPLETED = 'completed';

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_orders')
            ->using(CourseOrder::class)
            ->withPivot([
                'price',
                'price_after_discount',
                'discount'
            ])
            ->as('course_orders');
    }

    public function coursesOrder()
    {
        return $this->hasMany(CourseOrder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
