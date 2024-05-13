<?php

namespace App\Http\Controllers\Web\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Courses\CourseLessonService;
use App\Http\Requests\web\Courses\CourseLessonStoreRequest;
use App\Models\Course;
use App\Models\User;

class CourseLessonController extends Controller
{
    protected $courseLessonService;

    public function __construct(CourseLessonService $courseLessonService)
    {
        $this->courseLessonService = $courseLessonService;
    }

    public function store(CourseLessonStoreRequest $request)
    {
        $data = $request->validated();
        $progress = $this->courseLessonService->store($data);
        return response()->json(['success' => "Lecture completed.", 'progress' => $progress]);
    }

    public function show($courseId, $lessonId)
    {
        //$this->authorize('StudentView', $course);
        $result = $this->courseLessonService->show($courseId, $lessonId);
        return view('courses.showCourse', $result);
    }
}
