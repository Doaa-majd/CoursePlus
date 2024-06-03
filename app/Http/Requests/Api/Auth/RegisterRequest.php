<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     title="RegisterRequest",
 *     schema="RegisterRequest",
 *     description="RegisterRequest",
 *     @OA\Property(property="name", type="string", ref="#/components/schemas/User/properties/name"),
 *     @OA\Property(property="email", type="string", ref="#/components/schemas/User/properties/email"),
 *     @OA\Property(property="password", type="string", ref="#/components/schemas/User/properties/password")
 * )
 */
class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ];
    }
}
