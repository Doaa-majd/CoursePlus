<?php

namespace App\Http\Controllers\Web\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Services\Courses\UserCourseService;

class UserCourseController extends Controller
{
    protected $userCourseService;

    public function __construct(UserCourseService $userCourseService)
    {
        $this->userCourseService = $userCourseService;
    }

    public function index()
    {
        return view('courses.showAllCourses', [
            'courses' => $this->userCourseService->index(),
        ]);
    }

    public function show($id)
    {
        //$this->authorize('StudentView', $course);
        $result = $this->userCourseService->show($id);
        return view('courses.showCourse', $result);
    }
}
