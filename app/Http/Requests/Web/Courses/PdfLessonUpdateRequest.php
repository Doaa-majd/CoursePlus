<?php

namespace App\Http\Requests\Web\Courses;

use Illuminate\Foundation\Http\FormRequest;

class PdfLessonUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|min:3',
            'lesson_id' => 'required|numeric|exists:lessons,id',
            'pdf_file' => 'required|mimes:pdf|max:30000'
        ];
    }
}
