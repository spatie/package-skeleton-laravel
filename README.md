# PayChangu Laravel SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mzati/paychangusdk.svg?style=flat-square)](https://packagist.org/packages/mzati/paychangusdk)
[![Tests](https://img.shields.io/github/actions/workflow/status/Mzati1/PaychanguLaravelSDK/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/Mzati1/PaychanguLaravelSDK/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mzati/paychangusdk.svg?style=flat-square)](https://packagist.org/packages/mzati/paychangusdk)

A robust and modular Laravel SDK for integrating PayChangu payment services. This package simplifies the process of initializing payments (Hosted Checkout & Direct Mobile Money) and verifying transactions.

## Features

- **Hosted Checkout**: Generate checkout URLs for easy payments.
- **Direct Mobile Money**: Charge mobile money wallets (Airtel Money, Mpamba) directly.
- **Verification**: Verify both checkout transactions and mobile money charges.
- **Modular Design**: Easily extensible.
- **Secure**: Strict typing and input validation.

## Installation

You can install the package via composer:

```bash
composer require mzati/paychangusdk
```

Publish the config file:

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
    | PayChangu API Base URL
    |--------------------------------------------------------------------------
    |
    | This is the root URL for the PayChangu API.
    | Specific endpoints (checkout, mobile-money) will be constructed from this.
    |
    */
    'api_base_url' => env('PAYCHANGU_API_BASE_URL', 'https://api.paychangu.com/'),
];
```

## Configuration

Add the following variables to your `.env` file:

```env
PAYCHANGU_API_PRIVATE_KEY=your_private_key_here
# Optional: Override Base URL (Defaults to https://api.paychangu.com/)
PAYCHANGU_API_BASE_URL=https://api.paychangu.com/
```

## Usage

### 1. Hosted Checkout (Payment Link)

Use this to redirect users to a PayChangu hosted page.

```php
use Mzati\Paychangu\Facades\Paychangu;

$response = Paychangu::create_checkout_link([
    'amount' => 5000,
    'email' => 'customer@example.com',
    'first_name' => 'John',
    'last_name' => 'Doe',
    'currency' => 'MWK',
    'return_url' => 'https://yoursite.com/success',
    'callback_url' => 'https://yoursite.com/callback',
    'meta' => ['order_id' => '123']
]);

if ($response['success']) {
    return redirect($response['checkout_url']);
}
```

**Verify Checkout Transaction:**

```php
$verification = Paychangu::verify_checkout('TXN_1234567890');
```

---

### 2. Direct Mobile Money (Custom UI)

Use this to charge a user's mobile wallet directly from your application.

**Step 1: Get Operators**
Fetch available mobile money operators (e.g., Airtel, TNM).

```php
$operators = Paychangu::mobile_money_operators();
// Returns list of operators with ref_id
```

**Step 2: Charge Wallet**

```php
$response = Paychangu::create_mobile_money_payment([
    'mobile_money_operator_ref_id' => 'operator_ref_id_from_step_1',
    'mobile' => '0991234567',
    'amount' => 5000,
    'charge_id' => 'unique_charge_id_generated_by_you',
    'email' => 'customer@example.com', // optional
    'first_name' => 'John', // optional
    'last_name' => 'Doe', // optional
]);

if ($response['success']) {
    // Payment initiated, user will get a prompt
}
```

## Structure

The package is structured to be modular and easy to understand:

- **Facades**: `Paychangu` facade provides a static interface to the main class.
- **Resources**: Contains the core logic for different API features (Checkout, MobileMoney, Verification).
- **Http**: Handles HTTP requests to the PayChangu API using Guzzle.
- **Tests**: Comprehensive test suite using Pest.

```
src/
├── Facades/
│   └── Paychangu.php
├── Http/
│   └── Client.php
├── Resources/
│   ├── BaseResource.php
│   ├── Checkout.php
│   ├── MobileMoney/
│   │   └── MobileMoney.php
│   └── Verification.php
├── Paychangu.php
└── PaychanguServiceProvider.php
```

## Development

We use [Pest](https://pestphp.com/) for testing and [PHPStan](https://phpstan.org/) for static analysis.

Run tests:
```bash
composer test
```

Run static analysis:
```bash
composer analyse
```

Format code:
```bash
composer format
```

For more details, please see [CONTRIBUTING.md](CONTRIBUTING.md).

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

If you discover a security vulnerability within this package, please send an e-mail to Mzati Tembo via [mzatitembo01@gmail.com](mailto:mzatitembo01@gmail.com).

## Credits

- [Mzati Tembo](https://github.com/Mzati1)
- [All Contributors](https://github.com/Mzati1/PaychanguLaravelSDK/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
