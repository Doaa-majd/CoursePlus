<?php

declare(strict_types=1);

namespace App\Services\Courses;

use App\Models\Rating;

class RatingService
{
    public function store(array $data)
    {
        Rating::updateOrCreate([
            'user_id' => \Auth::id(),
            'course_id' => $data['course_id'],
        ], [
            'rating_num' => $data['rating_num'],
        ]);
    }

    public function getCourseRate(int $courseId)
    {
        $rating = Rating::where('course_id', $courseId)->avg('rating_num');
        return $rating;
    }

    public function calculateCourseRate($courseRating)
    {
        $rattingResult = [];
        foreach ($courseRating as $key => $ratting) {
            $rattingResult[$key] = $ratting->rating_num;
        }
        $count = count($courseRating);
        $rate = array_count_values($rattingResult); // count occurance of each element in array

        foreach ($rate as $key => $ratting) {
            $rate[$key] = floor($ratting / $count * 100);
        }

        return $rate;
    }

    public function getUserRate($courseId)
    {
        $rating = Rating::where('course_id', $courseId)->where('user_id', \Auth::id())->first();
        return $rating ? $rating->rating_num : 0;
    }
}
