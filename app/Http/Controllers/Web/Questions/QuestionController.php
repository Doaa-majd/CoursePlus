<?php

namespace App\Http\Controllers\Web\Questions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Questions\QuestionService;
use App\Http\Requests\web\Questions\QuestionStoreRequest;
use App\Http\Requests\web\Questions\QuestionUpdateRequest;

class QuestionController extends Controller
{
    protected $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function store(QuestionStoreRequest $request)
    {
        $data = $request->validated();
        $question = $this->questionService->store($data);
        return response()->json(['success' => "Question Created successfully.",
            'question' => $question,
            'user' => \Auth::user()->name,
         ]);
    }

    public function update(QuestionUpdateRequest $request, int $id)
    {
        $data = $request->validated();
        $question = $this->questionService->update($data, $id);
        return response()->json(['success' => "Question updated successfully.",
         'question' => $question
         ]);
    }

    public function delete($id)
    {
        $this->questionService->delete($id);
        return response()->json('question Deleted ');
    }
}
