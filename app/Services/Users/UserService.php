<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\Models\User;
use App\Models\Profile;
use App\Models\Permission;
use App\Models\Lesson;
use App\Models\LessonUser;
use Illuminate\Support\Facades\Auth;

class UserService
{

    public function hasPermission(string $name)
    {
        return Permission::where('user_id', Auth::id())->where('permission', $name)->count();
    }

    public function getInstructorId(int $courseId)
    {
        $courseUser =  CourseUser::where('course_id', $courseId)->where('user_status', 'instructor')->first();
        if ($courseUser) {
            return $courseUser->user_id;
        } else {
            return 0;
        }
    }

    public function getStudentId(int $courseId)
    {
        $courseUser = CourseUser::where('course_id', $courseId)->where('user_id', Auth::id())->first();
        if ($courseUser) {
            return $courseUser->user_id;
        } else {
            return 0;
        }
    }

    public function calculateUserProgress($courseId): float
    {
        $courseLessonsNumber = Lesson::where('course_id', $courseId)->get()->Count();
        $completedLessonsNumber = LessonUser::where('user_id', Auth::id())->where('course_id', $courseId)->get()->Count();
        if ($completedLessonsNumber < 1) {
            return 0;
        } else {
            return floor($completedLessonsNumber * 100 / $courseLessonsNumber);
        }
    }

    public function getUsers()
    {
        return User::orderBy('created_at', 'desc')->paginate(6);
    }
}
