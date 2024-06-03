<?php

namespace App\Http\Requests\Api\Categories;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     title="CategoryUpdateRequest",
 *     schema="CategoryUpdateRequest",
 *     description="CategoryUpdateRequest",
 *     @OA\Property(property="name", type="string", ref="#/components/schemas/Category/properties/name"),
 *     @OA\Property(property="parent_id", type="number", ref="#/components/schemas/Category/properties/parent_id")
 * )
 */

class CategoryUpdateRequest extends FormRequest
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
            'parent_id' => 'nullable|numeric'
        ];
    }
}
