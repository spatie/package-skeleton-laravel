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
    | PayChangu Payment URL
    |--------------------------------------------------------------------------
    |
    | This is the base URL for the PayChangu payment API.
    | Endpoints will be constructed by appending to this URL.
    | e.g. /verify
    |
    */
    'payment_url' => env('PAYCHANGU_PAYMENT_URL'),
];
