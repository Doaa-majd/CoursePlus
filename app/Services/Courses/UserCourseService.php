<?php

declare(strict_types=1);

namespace App\Services\Courses;

use App\Models\Course;
use App\Models\Profile;
use App\Models\CourseUser;
use App\Models\Lesson;
use App\Services\Courses\CourseService;
use App\Services\Courses\RatingService;
use App\Services\Users\UserService;
use Illuminate\Support\Arr;

class UserCourseService
{
    protected $courseService;
    protected $ratingService;
    protected $userService;

    public function __construct(
        CourseService $courseService,
        RatingService $ratingService,
        UserService $userService
    ) {
        $this->courseService = $courseService;
        $this->ratingService = $ratingService;
        $this->userService = $userService;
    }

    public function index()
    {
        $courses =  Course::whereHas('courseUsers', function ($q) {
            $q->where('user_id', \Auth::id());
        })->get();
        return $courses;
    }

    public function getCourseUsers($courseId)
    {
        return CourseUser::where('course_id', $courseId)->count();
    }

    public function isUserEnrolled($courseId)
    {
        return CourseUser::where('user_id', \Auth::id())->where('course_id', $courseId)->first() ? true : false;
    }

    public function show($courseId)
    {
        return $this->getCourseData($courseId);
    }

    public function getCourseData($courseId, $lessonId = 0)
    {
        $course = $this->courseService->getCourseWithRelations($courseId);
        if ($lessonId) {
            $filePath = Lesson::where('id', $lessonId)->first()->lessonable->path;
        } else {
            $filePath = $course->sections[0]->Lessones[0]->lessonable->path;
        }
        return [
            'course' => $course,
            'file_type' => Arr::last(explode('.', $filePath)) == 'pdf' ? 'pdf' : 'video',
            'file_path' => $filePath,
            'rating' => $this->ratingService->calculateCourseRate($course->rating),
            'ratingAvg' => $this->ratingService->getCourseRate($course->id),
            'userRating' => $this->ratingService->getUserRate($course->id),
            'instructor' => Profile::where('user_id', $course->courseUsers[0]->user_id)->first(),
            'userProgress' => $this->userService->calculateUserProgress($course->id)
        ];
    }
}
