<?php

namespace App\Http\Requests\Web\Courses;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Base64;

class VideoLessonStoreRequest extends FormRequest
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
            'course_id' => 'required|numeric|exists:courses,id',
            'section_id' => 'required|numeric|exists:sections,id',
            'video64' => ['nullable', new Base64([
                'video/mp4',
                'video/x-msvideo',
                'video/x-ms-wmv',
                'video/mpeg',
                'video/quicktime',
                'video/webm',
                'video/3gpp',
                'video/ogg',
            ])],
            'external_url' => 'nullable|string',
            'description' => 'nullable|string|max:400,min:10',
            'duration' => 'required|string',
            'pdf64' => ['nullable', new Base64(['application/pdf'])]
        ];
    }
}
