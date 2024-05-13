<?php

namespace App\Http\Controllers\Web\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Profile;
use App\Services\Courses\RatingService;
use App\Services\Courses\UserCourseService;
use App\Services\Courses\VideoLessonService;
use App\Services\Courses\CourseService;
use App\Services\Carts\CartService;
use App\Services\Coupons\CouponService;

class CourseController extends Controller
{
    protected $courseService;
    protected $ratingService;
    protected $userCourseService;
    protected $videoLessonService;
    protected $cartService;
    protected $couponService;

    public function __construct(
        CourseService $courseService,
        RatingService $ratingService,
        UserCourseService $userCourseService,
        VideoLessonService $videoLessonService,
        CartService $cartService,
        CouponService $couponService
    ) {
        $this->courseService = $courseService;
        $this->ratingService = $ratingService;
        $this->userCourseService = $userCourseService;
        $this->videoLessonService = $videoLessonService;
        $this->cartService = $cartService;
        $this->couponService = $couponService;
    }

    public function show($id)
    {
        $course = Course::where('id', $id)->with('category', 'sections.lessones.lessonable')->first();
        $instructor = Profile::where('user_id', $course->courseUsers[0]->user_id)->first();

            return view('courses.show', [
                'course' => $course,
                'instructor' => $instructor,
                'rating' => floor($this->ratingService->getCourseRate($course->id)),
                'courseUsers' => $this->userCourseService->getCourseUsers($course->id),
                'lessonsCount' => $this->videoLessonService->getLessonsCount($course->id),
                'isUserEnrolled' => $this->userCourseService->isUserEnrolled($course->id),
                'featuredCourses' => $this->courseService->getCategoryCourses($course->category->id),
                'isCourseInCart' => $this->cartService->isCourseInCart($course->id),
                'couponData' => $this->couponService->getCouponIfApplied($course->id)
            ]);
    }
}
