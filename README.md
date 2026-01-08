# PayChangu Laravel SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mzati/paychangusdk.svg?style=flat-square)](https://packagist.org/packages/mzati/paychangusdk)
[![Tests](https://img.shields.io/github/actions/workflow/status/Mzati1/PaychanguLaravelSDK/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/Mzati1/PaychanguLaravelSDK/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mzati/paychangusdk.svg?style=flat-square)](https://packagist.org/packages/mzati/paychangusdk)

A robust and modular Laravel SDK for integrating PayChangu payment services. This package simplifies the process of initializing payments (Hosted Checkout, Mobile Money, Card, Bank) and managing payouts, bill payments, and airtime.

## Features

- **Hosted Checkout**: Generate checkout URLs for easy payments.
- **Mobile Money**: Charge mobile money wallets (Airtel Money, Mpamba) directly.
- **Card Payments**: Charge cards, verify transactions, and process refunds.
- **Direct Charge (Bank)**: Initiate bank transfers.
- **Payouts**: Send money to mobile money wallets and bank accounts.
- **Bill Payments**: Validate and pay bills (LWB, ESCOM, etc.).
- **Airtime**: Recharge airtime (TNM, Airtel).
- **Verification**: Verify transactions across all services.

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
    return redirect($response['data']['checkout_url']);
}
```

**Verify Checkout Transaction:**

```php
$verification = Paychangu::verify_checkout('TXN_1234567890');
```

---

### 2. Mobile Money Payments

**Get Supported Operators:**

```php
$operators = Paychangu::mobile_money_operators();
```

**Charge Mobile Money Wallet:**

```php
$response = Paychangu::create_mobile_money_payment([
    'mobile' => '0999123456',
    'mobile_money_operator_ref_id' => 'mpamba_ref_id', // Get from operators list
    'amount' => 1000,
    'charge_id' => 'unique_charge_id_123',
]);
```

**Verify Payment:**

```php
$verification = Paychangu::verify_mobile_money_payment('unique_charge_id_123');
```

**Get Payment Details:**

```php
$details = Paychangu::get_mobile_money_payment_details('unique_charge_id_123');
```

---

### 3. Direct Charge (Bank Transfer)

**Initiate Bank Charge:**

```php
$response = Paychangu::create_direct_charge_payment([
    'currency' => 'MWK',
    'amount' => 50000,
    'charge_id' => 'bank_charge_001',
]);
```

**Get Transaction Details:**

```php
$details = Paychangu::get_direct_charge_details('bank_charge_001');
```

---

### 4. Card Payments

**Charge Card:**

```php
$response = Paychangu::create_card_payment([
    'card_number' => '4000123456789010',
    'expiry' => '12/25',
    'cvv' => '123',
    'cardholder_name' => 'John Doe',
    'amount' => 5000,
    'currency' => 'MWK',
    'charge_id' => 'card_charge_001',
    'redirect_url' => 'https://yoursite.com/card-callback',
]);
```

**Verify Card Charge:**

```php
$verification = Paychangu::verify_card_payment('card_charge_001');
```

**Refund Card Charge:**

```php
$refund = Paychangu::refund_card_payment('card_charge_001');
```

---

### 5. Mobile Money Payouts

**Get Payout Operators:**

```php
$operators = Paychangu::mobile_money_payout_operators();
```

**Initialize Payout:**

```php
$response = Paychangu::create_mobile_money_payout([
    'mobile' => '0888123456',
    'mobile_money_operator_ref_id' => 'airtel_money_ref_id',
    'amount' => 2000,
    'charge_id' => 'payout_001',
]);
```

**Get Payout Details:**

```php
$details = Paychangu::get_mobile_money_payout_details('payout_001');
```

---

### 6. Bank Payouts

**Get Supported Banks:**

```php
$banks = Paychangu::get_supported_banks_for_payout('MWK');
```

**Initialize Bank Payout:**

```php
$response = Paychangu::create_bank_payout([
    'bank_uuid' => 'bank_uuid_here',
    'amount' => 100000,
    'charge_id' => 'bank_payout_001',
    'bank_account_name' => 'Jane Doe',
    'bank_account_number' => '100200300',
]);
```

**Get Payout Details:**

```php
$details = Paychangu::get_bank_payout_details('bank_payout_001');
```

**List All Bank Payouts:**

```php
$allPayouts = Paychangu::get_all_bank_payouts();
```

---

### 7. Bill Payments

**Get Billers:**

```php
$billers = Paychangu::get_billers();
```

**Get Biller Details:**

```php
$billerDetails = Paychangu::get_biller_details('ESCOM');
```

**Validate Bill:**

```php
$validation = Paychangu::validate_bill([
    'biller' => 'ESCOM',
    'account' => '123456789',
]);
```

**Pay Bill:**

```php
$payment = Paychangu::pay_bill([
    'biller' => 'ESCOM',
    'account' => '123456789',
    'amount' => 5000,
    'reference' => 'bill_payment_001',
]);
```

**Get Transaction Details:**

```php
$details = Paychangu::get_bill_transaction('bill_payment_001');
```

**Get Statistics:**

```php
$stats = Paychangu::get_bill_statistics();
```

---

### 8. Airtime

**Buy Airtime:**

```php
$airtime = Paychangu::buy_airtime([
    'phone' => '0888123456',
    'amount' => 1000,
    'reference' => 'airtime_ref_001',
]);
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

- [Mzati](https://github.com/Mzati1)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
