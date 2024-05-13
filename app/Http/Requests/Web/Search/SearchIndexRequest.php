<?php

namespace App\Http\Requests\Web\Search;

use Illuminate\Foundation\Http\FormRequest;

class SearchIndexRequest extends FormRequest
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
            'search' => 'nullable|string',
            'category.*' => 'nullable|array',
            'min' => 'nullable|numeric|min:1',
            'max' => 'nullable|numeric|min:1'
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'search' => $this->route()->parameter('search'),
            'category' => $this->route()->parameter('category'),
            'min' => $this->route()->parameter('min'),
            'max' => $this->route()->parameter('max')
        ]);
    }
}
