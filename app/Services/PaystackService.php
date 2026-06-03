<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class PaystackService
{
    /**
     * @param  array{email: string, amount: int, reference: string, callback_url: string, currency?: string, metadata?: array<string, mixed>}  $payload
     * @return array<string, mixed>
     */
    public function initializeTransaction(array $payload): array
    {
        $response = Http::withToken($this->secretKey())
            ->acceptJson()
            ->post($this->baseUrl().'/transaction/initialize', [
                'email' => $payload['email'],
                'amount' => $payload['amount'],
                'reference' => $payload['reference'],
                'currency' => $payload['currency'] ?? 'NGN',
                'callback_url' => $payload['callback_url'],
                'metadata' => $payload['metadata'] ?? [],
            ]);

        if (! $response->successful() || ! $response->json('status')) {
            throw new RuntimeException($response->json('message') ?? 'Unable to initialize Paystack payment.');
        }

        /** @var array<string, mixed> $data */
        $data = $response->json('data');

        return $data;
    }

    /**
     * @return array<string, mixed>
     */
    public function verifyTransaction(string $reference): array
    {
        $response = Http::withToken($this->secretKey())
            ->acceptJson()
            ->get($this->baseUrl().'/transaction/verify/'.urlencode($reference));

        if (! $response->successful() || ! $response->json('status')) {
            throw new RuntimeException($response->json('message') ?? 'Unable to verify Paystack payment.');
        }

        /** @var array<string, mixed> $data */
        $data = $response->json('data');

        return $data;
    }

    public function generateReference(): string
    {
        return 'CCH_'.Str::upper(Str::random(16));
    }

    private function secretKey(): string
    {
        $key = config('paystack.secretKey');

        if (! is_string($key) || $key === '') {
            throw new RuntimeException('Paystack secret key is not configured.');
        }

        return $key;
    }

    private function baseUrl(): string
    {
        return rtrim((string) config('paystack.paymentUrl'), '/');
    }
}
