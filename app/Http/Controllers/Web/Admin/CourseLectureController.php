<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Courses\CourseService;

class CourseLectureController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function show($id)
    {
        $course = $this->courseService->getCourseLessons($id);
        return view('admin.courses.content')->with('course', $course);
    }
}
