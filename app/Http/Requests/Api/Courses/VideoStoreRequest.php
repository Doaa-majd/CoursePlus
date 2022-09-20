<?php

namespace App\Http\Requests\Api\Courses;

use Illuminate\Foundation\Http\FormRequest;

class VideoStoreRequest extends FormRequest
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
            'path' => 'required|mimetypes:video/avi,video/mp4,video/mpeg,video/quicktime,video/x-flv|max:60000',//60 m
            'course_id' => 'required|numeric|exists:courses,id',
        ];
    }
}
