
<?php

return [
    'api_encryption_key' => env('API_ENCRYPTION_KEY'),
    'request_header' => env('KEY_MANAGER_REQUREST_HEADER', 'x-blackbank-key'),
    'api_public_key_prefix' => env('KEY_MANAGER_API_PUBLIC_KEY_PREFIX', 'bb-auth-puk'),
    'api_private_key_prefix' => env('KEY_MANAGER_API_PRIVATE_KEY_PREFIX', 'bb-auth-prk'),
    'client_charge_percentage' => env('CLIENT_CHARGE_PERCENTAGE', '0.5'),
    'client_max_charge' => env('CLIENT_MAX_CHARGE', '2000')
];
