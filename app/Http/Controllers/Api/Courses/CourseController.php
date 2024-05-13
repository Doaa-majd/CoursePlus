<?php

namespace App\Http\Controllers\Api\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Courses\CourseService;
use App\Http\Resources\Api\Courses\CourseResource;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index(Request $request)
    {
        return response()->json(
            CourseResource::collection(
                $this->courseService->getCourses()
            )
        );
    }

    public function store(CourseStoreRequest $request)
    {
        $data = $request->validated();
        $course = $this->courseService->store($data);
        return response()->json([
            'id' => $course->id
        ], 201);
    }

    public function show(int $id)
    {
        $this->validateId($id);
        $course = $this->courseService->getCourseById($id);
        if (!$course) {
            abort(404, 'Course not found');
        }
        return response()->json([
            CourseResource::collection($course)
        ], 201);
    }

    public function update(CourseUpdateRequest $request, int $id)
    {
        $this->validateId($id);
        $data = $request->validated();
        $this->courseService->updateCourse($data, $id);
        return response()->json([]);
    }

    public function destroy(int $CourseId)
    {
        $this->validateId($CourseId);
        $this->courseService->delete($CourseId);
        return response()->json([], 204);
    }

    public function validateId($id)
    {
        Validator::validate([
            'id' => $id
        ], [
            'id' => 'required|numeric|exists:courses,id'
        ]);
    }
}
