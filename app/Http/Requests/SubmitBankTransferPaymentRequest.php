<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubmitBankTransferPaymentRequest extends FormRequest
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
        $currencies = collect(config('bank.accounts'))
            ->pluck('currency')
            ->all();

        return [
            'bank_account_currency' => ['required', 'string', Rule::in($currencies)],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'bank_account_currency.required' => 'Please select the account you paid into.',
            'bank_account_currency.in' => 'Please select a valid bank account.',
        ];
    }
}
