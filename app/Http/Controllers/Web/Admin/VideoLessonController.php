<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Web\Courses\LessonStoreRequest;
use App\Http\Requests\Web\Courses\LessonUpdateRequest;
use App\Services\Courses\VideoLessonService;
use App\Models\Video;
use App\Models\Lesson;
use Illuminate\Support\Facades\Validator;

class VideoLessonController extends Controller
{
    protected $videoLessonService;

    public function __construct(VideoLessonService $videoLessonService)
    {
        $this->videoLessonService = $videoLessonService;
    }

    public function store(LessonStoreRequest $request)
    {
        $data = $request->validated();
        $lesson = $this->videoLessonService->store($data);
        return response()->json(['success' => "Section Created successfully.", 'lesson' => $lesson]);
    }

    public function update(LessonUpdateRequest $request)
    {
        $data = $request->validated();
        $lesson = $this->videoLessonService->update($data);

        return response()->json(['success' => "Lecture Updated successfully.", 'lesson' => $lesson]);
    }

    public function delete(int $lessonId)
    {
        $this->validateId($lessonId);
        $this->videoLessonService->deleteLesson($lessonId);
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
