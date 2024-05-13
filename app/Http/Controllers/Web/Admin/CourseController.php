<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Courses\CourseService;
use App\Models\Course;
use App\Services\Categories\CategoryService;
use App\Http\Requests\Api\Courses\CourseStoreRequest;
use App\Http\Requests\Api\Courses\CourseUpdateRequest;

class CourseController extends Controller
{
    protected $courseService;
    protected $categoryService;

    public function __construct(CourseService $courseService, CategoryService $categoryService)
    {
        $this->courseService = $courseService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Course::class);
        return view('admin.courses.index')->with('courses', $this->courseService->getCoursesByUserType());
    }

    public function create()
    {
        $this->authorize('create', Course::class);
        return view('admin.courses.create')->with('categories', $this->categoryService->getCategories());
    }

    public function store(CourseStoreRequest $request)
    {
        $this->authorize('create', Course::class);
        $data = $request->validated();
        $course = $this->courseService->storeCourse($data);
        return \Redirect::route('admin.courses.show', $course->id)
            ->with('alert.success', "Course ({$course->title}) created!");
    }

    public function update(CourseUpdateRequest $request, Course $course)
    {
        $this->authorize('update', $course);
        $data = $request->validated();
        $this->courseService->update($data, $course);

        return \Redirect::route('admin.courses.show', $course->id)
            ->with('alert.success', "Course ({$course->title}) Updated!")
            ->with('categories', $this->categoryService->getCategories());
    }

    public function show(Course $course)
    {
        //$this->authorize('view', Course::class);
        return view('admin.courses.show')->with('course', $course)
            ->with('categories', $this->categoryService->getCategories());
    }

    public function delete(Course $course)
    {
        $this->authorize('delete', $course);
        $course->delete();
        if ($course->image) {
            \Storage::disk('images')->delete($course->image);
        }
        return response()->json(['url' => url('/admin/courses')]);
    }

}
