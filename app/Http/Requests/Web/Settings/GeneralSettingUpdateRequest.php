<?php

namespace App\Http\Requests\web\Settings;

use Illuminate\Foundation\Http\FormRequest;

class GeneralSettingUpdateRequest extends FormRequest
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
            'commission' => 'required|numeric|max:100|min:0',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:30000',
        ];
    }
}
