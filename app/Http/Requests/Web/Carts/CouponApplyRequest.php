<?php

namespace App\Http\Requests\web\Carts;

use Illuminate\Foundation\Http\FormRequest;

class CouponApplyRequest extends FormRequest
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
            'price' => 'required|numeric|max:100',
            'course_id' => 'required|numeric|exists:courses,id'
        ];
    }
}
