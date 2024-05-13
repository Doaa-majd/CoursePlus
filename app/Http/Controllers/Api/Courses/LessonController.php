<?php

namespace App\Http\Controllers\Api\Courses;

use App\Http\Controllers\Controller;
use App\Services\Courses\VideoLessonService;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\Courses\LessonStoreRequest;
use App\Http\Requests\Api\Courses\LessonUpdateRequest;

class LessonController extends Controller
{
    protected $videoLessonService;

    public function __construct(VideoLessonService $videoLessonService)
    {
        $this->videoLessonService = $videoLessonService;
    }

    public function store(LessonStoreRequest $request)
    {
        $data = $request->validated();
        $lesson = $this->videoLessonService->storeLesson($data);
        return response()->json([
            'id' => $lesson->id
        ], 201);
    }

    public function show(int $id)
    {
        $this->validateId($id);
        $lessonId = $this->videoLessonService->getLessonById($id);
        return response()->json([
            'id' => $lessonId
        ], 201);
    }

    public function update(LessonUpdateRequest $request, int $id)
    {
        $this->validateId($id);
        $data = $request->validated();
        $this->videoLessonService->updateLesson($data, $id);
        return response()->json([]);
    }

    public function destroy(int $lessonId)
    {
        $this->validateId($lessonId);
        $this->videoLessonService->delete($lessonId);
        return response()->json([], 204);
    }


    public function validateId($id)
    {
        Validator::validate([
            'id' => $id
        ], [
            'id' => 'required|numeric|exists:lessons,id'
        ]);
    }
}
