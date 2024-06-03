<?php

namespace App\Http\Requests\Web\Courses;

use Illuminate\Foundation\Http\FormRequest;

class CourseUpdateRequest extends FormRequest
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
            'title' => 'nullable|string|max:255|min:3',
            'sub_title' => 'nullable|string|max:500|min:3',
            'description' => 'nullable|string|max:1000|min:3',
            'category_id' => 'nullable|numeric|exists:categories,id',
            'languge' => 'nullable|in:ar,en',
            'image' => 'nullable|string',
            'price' => 'nullable|numeric',
        ];
    }
}
