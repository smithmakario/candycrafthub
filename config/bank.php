<?php

return [

    'name' => env('BANK_ACCOUNT_NAME', 'Candy Craft Hub'),

    'bank' => env('BANK_NAME', 'Providus Bank'),

    'accounts' => [
        [
            'currency' => 'NGN',
            'label' => 'NAIRA',
            'number' => env('BANK_ACCOUNT_NGN', '1309749995'),
        ],
        [
            'currency' => 'USD',
            'label' => 'USD',
            'number' => env('BANK_ACCOUNT_USD', '1309755640'),
        ],
        [
            'currency' => 'GBP',
            'label' => 'GBP',
            'number' => env('BANK_ACCOUNT_GBP', '1309755664'),
        ],
    ],

];
