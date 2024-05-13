<?php

declare(strict_types=1);

namespace App\Services\Courses;

use App\Models\Course;
use App\Models\LessonUser;
use App\Services\Courses\UserCourseService;
use App\Services\Users\UserService;

class CourseLessonService
{
    protected $userCourseService;
    protected $userService;

    public function __construct(
        UserCourseService $userCourseService,
        UserService $userService
    ) {
        $this->userCourseService = $userCourseService;
        $this->userService = $userService;
    }

    public function store($data)
    {
        $lessonUser = LessonUser::where('user_id', \Auth::id())
            ->where('course_id', $data['course_id'])
            ->where('lesson_id', $data['lesson_id'])
            ->first();
        if ($lessonUser) {
            $lessonUser->delete();
        } else {
            LessonUser::create([
                'user_id' => \Auth::id(),
                'course_id' => $data['course_id'],
                'lesson_id' => $data['lesson_id']
            ]);
        }

        $userProgress = $this->userService->calculateUserProgress($data['course_id']);
        return $userProgress;
    }

    public function show($courseId, $lessonId)
    {
        return $this->userCourseService->getCourseData($courseId, $lessonId);
    }

}
