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

## Configuration

Add the following variables to your `.env` file:

```env
PAYCHANGU_API_PRIVATE_KEY=your_private_key_here
# Base URL for Mobile Money Payments
PAYCHANGU_PAYMENT_URL=https://api.paychangu.com/mobile-money/payments
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

**Step 3: Verify Payment**

```php
$verification = Paychangu::verify_mobile_money_payment('unique_charge_id_generated_by_you');
```

**Step 4: Get Payment Details**

```php
$details = Paychangu::get_mobile_money_payment_details('unique_charge_id_generated_by_you');
```

## Testing

```bash
composer test
```

## Internal Structure

For a detailed explanation of how the files work and the internal workflow, please see [STRUCTURE.md](STRUCTURE.md).

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
