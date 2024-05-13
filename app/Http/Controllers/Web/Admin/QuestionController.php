<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Questions\QuestionService;
use App\Http\Requests\web\Admin\QuestionUpdateRequest;

class QuestionController extends Controller
{
    protected $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function index()
    {
        $result = $this->questionService->getQuestions();
        return view('admin.questions.index')->with('questions', $result);
    }

    public function update(QuestionUpdateRequest $request)
    {
        $data = $request->validated();
        $question = $this->questionService->update($data, $data['id']);
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
