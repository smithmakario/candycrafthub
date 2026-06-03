<?php

namespace App\Http\Requests;

use App\EventType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePublicBookingRequest extends FormRequest
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
            'event_type' => ['required', Rule::enum(EventType::class)],
            'theme_color' => ['nullable', 'string', 'max:7'],
            'guest_count' => ['nullable', 'integer', 'min:1'],
            'event_date' => ['nullable', 'date', 'after_or_equal:today'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:50'],
        ];
    }
}
