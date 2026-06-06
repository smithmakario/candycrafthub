<?php

namespace App\Http\Requests;

use App\FulfillmentType;
use App\Models\User;
use App\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

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
        $rules = [
            'fulfillment_type' => ['required', Rule::enum(FulfillmentType::class)],
            'payment_method' => ['required', Rule::enum(PaymentMethod::class)],
            'delivery_address' => [
                Rule::requiredIf(fn (): bool => $this->input('fulfillment_type') === FulfillmentType::Delivery->value),
                'nullable',
                'string',
                'max:1000',
            ],
        ];

        if ($this->user()) {
            return $rules;
        }

        $rules['account_mode'] = ['required', Rule::in(['register', 'login'])];
        $rules['email'] = ['required', 'email', 'max:255'];
        $rules['password'] = ['required', 'string'];

        if ($this->input('account_mode') === 'register') {
            $rules['first_name'] = ['required', 'string', 'max:255'];
            $rules['last_name'] = ['required', 'string', 'max:255'];
            $rules['email'][] = Rule::unique(User::class);
            $rules['password'][] = 'confirmed';
            $rules['password'][] = Password::defaults();
            $rules['phone'] = [
                Rule::requiredIf(fn (): bool => $this->input('fulfillment_type') === FulfillmentType::Delivery->value),
                'nullable',
                'string',
                'max:255',
            ];
        }

        return $rules;
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'delivery_address.required' => 'Please enter a delivery address.',
            'email.unique' => 'An account with this email already exists. Please sign in instead.',
            'phone.required' => 'Please enter a phone number for delivery orders.',
        ];
    }
}
