<?php

declare(strict_types=1);

namespace Mzati\Paychangu;

use Illuminate\Support\Str;
use Mzati\Paychangu\Http\Client;
use Mzati\Paychangu\Resources\Checkout;
use Mzati\Paychangu\Resources\MobileMoney\MobileMoney;
use Mzati\Paychangu\Resources\Verification;

class Paychangu
{
    protected string $privateKey;
    protected string $apiBaseUrl;

    public function __construct()
    {
        $this->privateKey = config('paychangu.private_key') ?? '';
        $this->apiBaseUrl = config('paychangu.api_base_url') ?? 'https://api.paychangu.com/';

        // Ensure trailing slash
        if (! Str::endsWith($this->apiBaseUrl, '/')) {
            $this->apiBaseUrl .= '/';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Checkout (Hosted Page) Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Create a new checkout link (hosted payment page).
     */
    public function create_checkout_link(array $data): array
    {
        return $this->checkout()->create($data);
    }

    /**
     * Verify a hosted checkout transaction.
     */
    public function verify_checkout(string $txRef): array
    {
        return $this->verification()->verify($txRef);
    }

    /*
    |--------------------------------------------------------------------------
    | Mobile Money Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get all supported mobile money operators.
     */
    public function mobile_money_operators(): array
    {
        return $this->mobile_money()->getOperators();
    }

    /**
     * Charge a mobile money account directly.
     */
    public function create_mobile_money_payment(array $data): array
    {
        return $this->mobile_money()->charge($data);
    }

    /**
     * Verify a mobile money payment.
     */
    public function verify_mobile_money_payment(string $chargeId): array
    {
        return $this->mobile_money()->verify($chargeId);
    }

    /**
     * Get details of a mobile money payment.
     */
    public function get_mobile_money_payment_details(string $chargeId): array
    {
        return $this->mobile_money()->details($chargeId);
    }

    /*
    |--------------------------------------------------------------------------
    | Resource Accessors
    |--------------------------------------------------------------------------
    */

    public function checkout(): Checkout
    {
        // Constructed as: https://api.paychangu.com/payment
        $url = $this->apiBaseUrl . 'payment';
        $client = new Client($this->privateKey, $url);
        return new Checkout($client);
    }

    public function mobile_money(): MobileMoney
    {
        // Constructed as: https://api.paychangu.com/mobile-money/
        $url = $this->apiBaseUrl . 'mobile-money/';
        $client = new Client($this->privateKey, $url);
        return new MobileMoney($client);
    }

    public function verification(): Verification
    {
        // Verification typically uses the payment/checkout base
        $url = $this->apiBaseUrl . 'payment';
        $client = new Client($this->privateKey, $url);
        return new Verification($client);
    }
}
