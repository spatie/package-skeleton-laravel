<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PayChangu API Private Key
    |--------------------------------------------------------------------------
    |
    | This is the private key used to authenticate with the PayChangu API.
    |
    */
    'private_key' => env('PAYCHANGU_API_PRIVATE_KEY'),

    /*
    |--------------------------------------------------------------------------
    | PayChangu API Base URL
    |--------------------------------------------------------------------------
    |
    | This is the root URL for the PayChangu API.
    | Specific endpoints (checkout, mobile-money) will be constructed from this.
    |
    */
    'api_base_url' => env('PAYCHANGU_API_BASE_URL', 'https://api.paychangu.com/'),
];
