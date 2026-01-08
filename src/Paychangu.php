<?php

declare(strict_types=1);

namespace Mzati\Paychangu;

use Mzati\Paychangu\Http\Client;
use Mzati\Paychangu\Resources\Checkout;
use Mzati\Paychangu\Resources\MobileMoney\MobileMoney;
use Mzati\Paychangu\Resources\Verification;

class Paychangu
{
    protected Client $client;

    public function __construct()
    {
        $privateKey = config('paychangu.private_key') ?? '';
        $paymentUrl = config('paychangu.payment_url') ?? '';

        $this->client = new Client($privateKey, $paymentUrl);
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
        return new Checkout($this->client);
    }

    public function mobile_money(): MobileMoney
    {
        return new MobileMoney($this->client);
    }

    public function verification(): Verification
    {
        return new Verification($this->client);
    }
}
