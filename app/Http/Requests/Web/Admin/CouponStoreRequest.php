<?php

namespace App\Http\Requests\web\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CouponStoreRequest extends FormRequest
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
            'code' => 'required|string|max:6',
            'type' => 'required|string|in:fixed,percentage',
            'value' => 'nullable|numeric',
            'expired_date' => 'required|date_format:Y-m-d|after_or_equal:' . date('Y-m-d'),
            'max_usage' => 'nullable|numeric',
            'courses' => 'required'
        ];
    }
}
