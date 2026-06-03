<?php

namespace App\Http\Requests;

use App\FulfillmentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCheckoutRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:255'],
            'fulfillment_type' => ['required', Rule::enum(FulfillmentType::class)],
            'delivery_address' => [
                Rule::requiredIf(fn (): bool => $this->input('fulfillment_type') === FulfillmentType::Delivery->value),
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'delivery_address.required' => 'Please enter a delivery address.',
        ];
    }
}
