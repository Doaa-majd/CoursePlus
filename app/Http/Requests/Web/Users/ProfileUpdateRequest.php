<?php

namespace App\Http\Requests\web\Users;

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
            'fname' => 'required|string|max:255|min:3',
            'lname' => 'required|string|max:255|min:3',
            'address' => 'required|string|max:255|min:5',
            'country' => 'required|string|max:255|min:5',
            'interests' => 'required|string|max:255|min:3',
            'level' => 'required|string|max:255|min:6',
            'bio' => 'required|string|max:1500|min:10',
            'locale' => 'required|string',
            'image' => 'nullable'
        ];
    }
}
