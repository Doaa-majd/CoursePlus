<?php

declare(strict_types=1);

namespace App\Services\Questions;

use App\Models\Question;

class QuestionService
{
    public function getQuestions()
    {
        return Question::with('course', 'user')->get();
    }

    public function store(array $data)
    {
        $question = Question::create([
            'question' => $data['question'],
            'user_id' => \Auth::id(),
            'course_id' => $data['course_id'],
        ]);
        return $question;
    }

    public function update(array $data, int $id)
    {
        $question = Question::findOrFail($id);
        $question->update([
            'question' => $data['question'],
        ]);
        return $question;
    }

    public function delete($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
    }
}
