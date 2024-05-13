<?php

namespace App\Http\Requests\Api\Courses;

use Illuminate\Foundation\Http\FormRequest;

class SectionUpdateRequest extends FormRequest
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
            'course_id' => 'required|numeric|exists:courses,id',
            'name' => 'required|string|max:255|min:3',
            'section_id' => 'nullable|numeric|exists:sections,id'
        ];
    }
}
