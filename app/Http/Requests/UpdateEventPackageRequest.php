<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEventPackageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'uses_custom_pricing' => ['sometimes', 'boolean'],
            'price' => [
                Rule::requiredIf(fn (): bool => ! $this->boolean('uses_custom_pricing')),
                'nullable',
                'numeric',
                'min:0',
            ],
            'price_label' => [
                Rule::requiredIf(fn (): bool => $this->boolean('uses_custom_pricing')),
                'nullable',
                'string',
                'max:255',
            ],
            'price_interval' => ['required', 'string', 'max:20'],
            'features' => ['required', 'string'],
            'is_featured' => ['sometimes', 'boolean'],
            'badge_text' => ['nullable', 'string', 'max:255'],
            'button_text' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
