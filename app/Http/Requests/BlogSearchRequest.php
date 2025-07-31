<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'search' => 'nullable|string|max:255',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:50'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'search.string' => 'Search term must be a valid string.',
            'search.max' => 'Search term cannot exceed 255 characters.',
            'page.integer' => 'Page must be a valid number.',
            'page.min' => 'Page must be at least 1.',
            'per_page.integer' => 'Items per page must be a valid number.',
            'per_page.min' => 'Items per page must be at least 1.',
            'per_page.max' => 'Items per page cannot exceed 50.'
        ];
    }

    /**
     * Get the validated search term
     */
    public function getSearchTerm(): ?string
    {
        return $this->validated()['search'] ?? null;
    }

    /**
     * Get the validated page number
     */
    public function getPage(): int
    {
        return $this->validated()['page'] ?? 1;
    }

    /**
     * Get the validated per page count
     */
    public function getPerPage(): int
    {
        return $this->validated()['per_page'] ?? 10;
    }
}
