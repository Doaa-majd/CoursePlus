<?php

namespace App\Http\Requests\Api\Courses;

use Illuminate\Foundation\Http\FormRequest;

class CourseStoreRequest extends FormRequest
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
            'category_id' => 'required|numeric',
            'title' => 'required|string|max:255|min:3',
            'sub_title' => 'required|string|max:500|min:10',
            'languge' => 'required|in:ar,en',
            'description' => 'required|string|max:1000|min:10',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf,docx,doc,txt|max:30000',
            'price' => 'nullable|numeric',
            'status' => 'required|in:published,draft'
        ];
    }
}