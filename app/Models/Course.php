<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'course_id', 'id');
    }

    public function lessones()
    {
        return $this->hasMany(Lesson::class, 'course_id', 'id');
    }

    public function courseUsers()
    {
        return $this->hasMany(CourseUser::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'course_id', 'id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'course_orders');
        /*->using(CourseOrder::class)
        ->withPivot([
            'price',
            'discount',
            'price_after_discount'
        ]);*/
    }

    public function coursesOrder()
    {
        return $this->hasMany(CourseOrder::class);
    }
}
