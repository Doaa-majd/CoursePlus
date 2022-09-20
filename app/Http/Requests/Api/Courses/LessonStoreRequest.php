<?php

namespace App\Http\Requests\Api\Courses;

use App\Rules\LessonType as RulesLessonType;
use Illuminate\Foundation\Http\FormRequest;

class LessonStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|min:3',
            'course_id' => 'required|numeric|exists:courses,id',
            'section_id' => 'required|numeric|exists:sections,id',
            'lessonable_id' => 'required|numeric',
            'lessonable_type' => ['required', new RulesLessonType()]
        ];
    }
}
