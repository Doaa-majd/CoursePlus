<?php

namespace App\Http\Controllers\Web\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Courses\CourseService;
use App\Services\Categories\CategoryService;
use App\Models\Course;
use App\Http\Requests\Web\Courses\CourseStoreRequest;
use App\Http\Requests\Web\Courses\CourseUpdateRequest;

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
        return view('instructor.courses.index')->with(
            'courses',
            $this->courseService->getInstructorCourses(\Auth::id())
        );
    }

    public function createStep1()
    {
        return view('instructor.courses.createStep1');
    }

    public function createStep2(Request $request)//CourseCreateStep1Request
    {
        $type = '';
        if (session()->has('type')) {
            $type = session()->get('type');
        } else {
            $request->validate([
                'type' => 'required|string|in:single session,complete course',
            ]);
            $type = $request->type;
        }
        if ($request->has('type')) {
            session()->put('type', $request->type);
        }

        if ($type == $this->courseService::COMPLETE_COURSE_TYPE) {
            return view('instructor.courses.createCourseStep2');
        } else {
            return view('instructor.courses.createSessionStep2');
        }
    }

    public function createCourseStep3(Request $request)//CourseCreateCourseStep3Request
    {
        if (!session()->has('title') && !session()->has('sub_title') && !session()->has('description')) {
            $request->validate([
                'title' => 'required|string|max:255|min:3',
                'sub_title' => 'required|string|max:500|min:3',
                'description' => 'required|string|max:1000|min:3',
            ]);
        }
        if ($request->has('title')) {
            session()->put('title', $request->title);
        }
        if ($request->has('sub_title')) {
            session()->put('sub_title', $request->sub_title);
        }
        if ($request->has('description')) {
            session()->put('description', $request->description);
        }
        return view('instructor.courses.createCourseStep3');
    }

    public function createCourseStep4(Request $request)
    {
        if (!session()->has('category_id') && !session()->has('languge') && !session()->has('price')) {
            $request->validate([
                'category_id' => 'required|numeric|exists:categories,id',
                'languge' => 'required|string|in:ar,en',
                'price' => 'nullable|numeric|min:0',
            ]);
        }
        if ($request->has('category_id')) {
            session()->put('category_id', $request->category_id);
        }
        if ($request->has('languge')) {
            session()->put('languge', $request->languge);
        }
        if ($request->has('price')) {
            session()->put('price', $request->price);
        }
        return view('instructor.courses.createCourseStep4');
    }

    public function store(CourseStoreRequest $request)
    {
        $data = $request->validated();
        $course = $this->courseService->processCourse($data);
        return \Redirect::route('instructor.courses.show', $course->id);
    }

    public function show(Course $course)
    {
        return view('instructor.courses.editCourse')->with('course', $course);
    }

    public function update(CourseUpdateRequest $request, Course $course)
    {
        $data = $request->validated();
        $this->courseService->instructorUpdateCourse($data, $course);
        return response()->json(['success' => 'updated successfully']);
    }
}
