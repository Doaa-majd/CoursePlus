<?php

namespace App\Http\Requests\Web\Instructors;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'fname' => 'nullable|string|max:255|min:3',
            'lname' => 'nullable|string|max:255|min:3',
            'country' => 'nullable|string|max:255|min:3',
            'address' => 'nullable|string|max:255|min:6',
            'mobile' => 'nullable|string|max:15|min:13',
            'bio' => 'nullable|string|max:1500|min:10',
            'image' => 'nullable|string',
            'cover_image' => 'nullable|string'
        ];
    }
}
