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

This package supports both **Test** and **Live** environments. You can switch between them using an environment variable.

Add the following variables to your `.env` file:

```env
# Environment: 'test' or 'live'
PAYCHANGU_ENVIRONMENT=test

# API Keys
PAYCHANGU_API_TEST_KEY=your_test_public_key
PAYCHANGU_API_LIVE_KEY=your_live_public_key

# Base URL (Optional, defaults to https://api.paychangu.com/)
PAYCHANGU_API_BASE_URL=https://api.paychangu.com/
```

When `PAYCHANGU_ENVIRONMENT` is set to `test`, the SDK will automatically use `PAYCHANGU_API_TEST_KEY`. When set to `live`, it will use `PAYCHANGU_API_LIVE_KEY`.

## Usage

### 1. Hosted Checkout (Payment Link)

Use this method to generate a payment link that redirects users to a secure PayChangu hosted page to complete their payment.

```php
use Mzati\Paychangu\Facades\Paychangu;

try {
    $response = Paychangu::create_checkout_link([
        'amount' => 5000,
        'email' => 'customer@example.com',
        'first_name' => 'John',
        'last_name' => 'Doe',
        'currency' => 'MWK',
        'return_url' => 'https://yoursite.com/success',
        'callback_url' => 'https://yoursite.com/callback',
        'meta' => [
            'order_id' => 'ORD-123',
            'custom_field' => 'value'
        ]
    ]);

    if ($response['status'] === 'success') {
        // Redirect the user to the checkout page
        return redirect($response['checkout_url']);
    }

    // Handle error
    return back()->with('error', 'Unable to initiate payment.');

} catch (\Exception $e) {
    // Handle exception
    return back()->with('error', $e->getMessage());
}
```

**Verify Checkout Transaction:**

After the user returns from the payment page (to your `return_url`), you should verify the transaction using the transaction reference (often passed as `tx_ref` or similar in the query string, or you can track it via your `order_id`).

```php
$verification = Paychangu::verify_checkout('TXN_1234567890');

if ($verification['status'] === 'success' && $verification['data']['status'] === 'successful') {
    // Payment was successful
}
```

---

### 2. Direct Mobile Money (Custom UI)

Use this method if you want to build your own UI and charge a user's mobile wallet directly.

**Step 1: Get Supported Operators**

Fetch the list of available mobile money operators (e.g., Airtel Money, TNM Mpamba) to display to the user.

```php
$operators = Paychangu::mobile_money_operators();

// Example Output:
// [
//   ['ref_id' => 'airtel_money', 'name' => 'Airtel Money'],
//   ['ref_id' => 'tnm_mpamba', 'name' => 'TNM Mpamba']
// ]
```

**Step 2: Initiate Charge**

Once the user selects an operator and enters their phone number, initiate the charge.

```php
$chargeData = [
    'mobile_money_operator_ref_id' => 'airtel_money', // From Step 1
    'mobile' => '0991234567',
    'amount' => 5000,
    'charge_id' => 'unique_charge_id_' . time(), // You must generate a unique ID
    'email' => 'customer@example.com', // Optional
    'first_name' => 'John', // Optional
    'last_name' => 'Doe', // Optional
];

$response = Paychangu::create_mobile_money_payment($chargeData);

if ($response['status'] === 'success') {
    // The user will receive a USSD prompt on their phone to authorize the payment.
    // You should now poll for status or wait for a webhook.
}
```

**Step 3: Verify Payment / Check Status**

You can check the status of the mobile money payment using the `charge_id` you generated.

```php
$verification = Paychangu::verify_mobile_money_payment('unique_charge_id_123456');

if ($verification['status'] === 'success' && $verification['data']['status'] === 'successful') {
    // Payment complete
}
```

**Step 4: Get Payment Details**

Retrieve full details of a specific mobile money transaction.

```php
$details = Paychangu::get_mobile_money_payment_details('unique_charge_id_123456');
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
