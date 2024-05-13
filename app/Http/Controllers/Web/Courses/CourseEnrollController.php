<?php

namespace App\Http\Controllers\Web\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\web\Courses\CourseEnrollStoreRequest;
use App\Services\Courses\CourseEnrollService;

class CourseEnrollController extends Controller
{
    protected $courseEnrollService;

    public function __construct(CourseEnrollService $courseEnrollService)
    {
        $this->courseEnrollService = $courseEnrollService;
    }

    public function store(CourseEnrollStoreRequest $request)
    {
        $data = $request->validated();
        $result = $this->courseEnrollService->store($data);
        return \Redirect::route('user.courses.show', $data['course_id']);

    }
}
