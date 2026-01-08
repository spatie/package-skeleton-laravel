# PayChangu Laravel SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mzati/paychangusdk.svg?style=flat-square)](https://packagist.org/packages/mzati/paychangusdk)
[![Tests](https://img.shields.io/github/actions/workflow/status/Mzati1/PaychanguLaravelSDK/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/Mzati1/PaychanguLaravelSDK/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mzati/paychangusdk.svg?style=flat-square)](https://packagist.org/packages/mzati/paychangusdk)

A robust and modular Laravel SDK for integrating PayChangu payment services. This package simplifies the process of initializing payments and verifying transactions using the PayChangu API.

## Features

- **Easy Payment Initialization**: Generate checkout URLs with minimal setup.
- **Transaction Verification**: Verify payment status using transaction references.
- **Modular Design**: Easily extensible for future API endpoints.
- **Laravel Friendly**: Includes Facades and Service Providers for seamless integration.

## Installation

You can install the package via composer:

```bash
composer require mzati/paychangusdk
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="paychangu-config"
```

This is the contents of the published config file:

```php
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
    |
    */
    'payment_url' => env('PAYCHANGU_PAYMENT_URL'),
];
```

## Configuration

Add the following variables to your `.env` file:

```env
PAYCHANGU_API_PRIVATE_KEY=your_private_key_here
PAYCHANGU_PAYMENT_URL=https://api.paychangu.com/v1/mobile-money/payments
```

## Usage

### Initialize a Payment

To start a payment process, use the `Paychangu` facade. This will return a checkout URL where you can redirect the user.

```php
use Mzati\Paychangu\Facades\Paychangu;

$response = Paychangu::payments()->initiate([
    'amount' => 5000,
    'email' => 'customer@example.com',
    'first_name' => 'John',
    'last_name' => 'Doe',
    'currency' => 'MWK', // Optional, defaults to MWK
    'return_url' => 'https://yoursite.com/payment/success',
    'callback_url' => 'https://yoursite.com/payment/callback',
    'meta' => [
        'order_id' => '12345',
        'custom_field' => 'custom_value'
    ]
]);

if ($response['success']) {
    return redirect($response['checkout_url']);
}

// Handle error
dd($response['error']);
```

### Verify a Transaction

To verify a transaction, use the transaction reference (`tx_ref`) returned during initialization or in the callback.

```php
use Mzati\Paychangu\Facades\Paychangu;

$txRef = 'TXN_1234567890'; // The transaction reference
$verification = Paychangu::transactions()->verify($txRef);

if ($verification['success']) {
    // Payment was successful
    $data = $verification['data'];
    // Update your database...
} else {
    // Payment failed or is pending
    $error = $verification['error'];
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mzati Tembo](https://github.com/Mzati1)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
