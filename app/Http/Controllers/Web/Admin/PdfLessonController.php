<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Courses\PdfLessonService;
use App\Http\Requests\Web\Courses\PdfLessonStoreRequest;
use App\Http\Requests\Web\Courses\PdfLessonUpdateRequest;
use Illuminate\Support\Facades\Validator;

class PdfLessonController extends Controller
{
    protected $pdfLessonService;

    public function __construct(PdfLessonService $pdfLessonService)
    {
        $this->pdfLessonService = $pdfLessonService;
    }

    public function store(PdfLessonStoreRequest $request)
    {
        $data = $request->validated();
        $this->pdfLessonService->store($data);

        return response()->json(['successfully add new pdf']);
    }

    public function update(PdfLessonUpdateRequest $request)
    {
        $data = $request->validated();
        $this->pdfLessonService->update($data);

        return response()->json(['successfully update the pdf']);
    }

    public function delete(int $lessonId)
    {
        $this->validateId($lessonId);
        $this->pdfLessonService->delete($lessonId);
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
