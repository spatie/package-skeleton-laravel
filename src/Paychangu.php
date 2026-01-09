<?php

declare(strict_types=1);

namespace Paychangu\Laravel;

use Illuminate\Support\Str;
use Paychangu\Laravel\Http\Client;
use Paychangu\Laravel\Resources\Banks\Card;
use Paychangu\Laravel\Resources\Banks\DirectCharge;
use Paychangu\Laravel\Resources\BillPayments\Airtime;
use Paychangu\Laravel\Resources\BillPayments\Bill;
use Paychangu\Laravel\Resources\Checkout;
use Paychangu\Laravel\Resources\MobileMoney\MobileMoney;
use Paychangu\Laravel\Resources\Payouts\BankPayout;
use Paychangu\Laravel\Resources\Payouts\MobileMoneyPayout;
use Paychangu\Laravel\Resources\Verification;

class Paychangu
{
    protected string $privateKey;

    protected string $apiBaseUrl;

    public function __construct()
    {
        // Safely get config values, handling cases where config might not be available (e.g., during uninstall)
        if (function_exists('config')) {
            try {
                $this->privateKey = config('paychangu.private_key') ?? '';
                $this->apiBaseUrl = config('paychangu.api_base_url') ?? 'https://api.paychangu.com/';
            } catch (\Throwable $e) {
                // During uninstall or if config service is not available, use defaults
                $this->privateKey = '';
                $this->apiBaseUrl = 'https://api.paychangu.com/';
            }
        } else {
            // Config helper not available (e.g., during uninstall)
            $this->privateKey = '';
            $this->apiBaseUrl = 'https://api.paychangu.com/';
        }

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
     *
     * @param  array  $data  The checkout data (amount, email, etc.).
     * @return array The API response containing the checkout URL.
     */
    public function create_checkout_link(array $data): array
    {
        return $this->checkout()->create($data);
    }

    /**
     * Verify a hosted checkout transaction.
     *
     * @param  string  $txRef  The transaction reference.
     * @return array The verification result.
     */
    public function verify_checkout(string $txRef): array
    {
        return $this->verification()->verify($txRef);
    }

    /*
    |--------------------------------------------------------------------------
    | Direct Charge (Bank Transfer) Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Initiate a direct charge (Bank Transfer).
     *
     * @param  array  $data  The charge details.
     * @return array The API response.
     */
    public function create_direct_charge_payment(array $data): array
    {
        return $this->direct_charge()->create($data);
    }

    /**
     * Get details of a direct charge transaction.
     *
     * @param  string  $chargeId  The charge ID.
     * @return array The transaction details.
     */
    public function get_direct_charge_details(string $chargeId): array
    {
        return $this->direct_charge()->details($chargeId);
    }

    /*
    |--------------------------------------------------------------------------
    | Card Charge Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Charge a card.
     *
     * @param  array  $data  The card and charge details.
     * @return array The API response.
     */
    public function create_card_payment(array $data): array
    {
        return $this->card()->create($data);
    }

    /**
     * Verify a card charge.
     *
     * @param  string  $chargeId  The charge ID.
     * @return array The verification result.
     */
    public function verify_card_payment(string $chargeId): array
    {
        return $this->card()->verify($chargeId);
    }

    /**
     * Refund a card charge.
     *
     * @param  string  $chargeId  The charge ID.
     * @return array The refund result.
     */
    public function refund_card_payment(string $chargeId): array
    {
        return $this->card()->refund($chargeId);
    }

    /*
    |--------------------------------------------------------------------------
    | Mobile Money Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get all supported mobile money operators.
     *
     * @return array The list of operators.
     */
    public function mobile_money_operators(): array
    {
        return $this->mobile_money()->getOperators();
    }

    /**
     * Charge a mobile money account directly.
     *
     * @param  array  $data  The charge details.
     * @return array The API response.
     */
    public function create_mobile_money_payment(array $data): array
    {
        return $this->mobile_money()->charge($data);
    }

    /**
     * Verify a mobile money payment.
     *
     * @param  string  $chargeId  The charge ID.
     * @return array The verification result.
     */
    public function verify_mobile_money_payment(string $chargeId): array
    {
        return $this->mobile_money()->verify($chargeId);
    }

    /**
     * Get details of a mobile money payment.
     *
     * @param  string  $chargeId  The charge ID.
     * @return array The payment details.
     */
    public function get_mobile_money_payment_details(string $chargeId): array
    {
        return $this->mobile_money()->details($chargeId);
    }

    /*
    |--------------------------------------------------------------------------
    | Payouts Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get all mobile money operators (for payouts).
     *
     * @return array The list of operators.
     */
    public function mobile_money_payout_operators(): array
    {
        return $this->mobile_money_payout()->getOperators();
    }

    /**
     * Initialize a mobile money payout.
     *
     * @param  array  $data  The payout details.
     * @return array The API response.
     */
    public function create_mobile_money_payout(array $data): array
    {
        return $this->mobile_money_payout()->create($data);
    }

    /**
     * Get details of a mobile money payout.
     *
     * @param  string  $chargeId  The charge ID.
     * @return array The payout details.
     */
    public function get_mobile_money_payout_details(string $chargeId): array
    {
        return $this->mobile_money_payout()->details($chargeId);
    }

    /**
     * Get supported banks for payouts.
     *
     * @param  string  $currency  The currency code (default: MWK).
     * @return array The list of supported banks.
     */
    public function get_supported_banks_for_payout(string $currency = 'MWK'): array
    {
        return $this->bank_payout()->getSupportedBanks($currency);
    }

    /**
     * Initialize a bank payout.
     *
     * @param  array  $data  The payout details.
     * @return array The API response.
     */
    public function create_bank_payout(array $data): array
    {
        return $this->bank_payout()->create($data);
    }

    /**
     * Get details of a bank payout.
     *
     * @param  string  $chargeId  The charge ID.
     * @return array The payout details.
     */
    public function get_bank_payout_details(string $chargeId): array
    {
        return $this->bank_payout()->details($chargeId);
    }

    /**
     * Get all bank payouts.
     *
     * @return array The list of all bank payouts.
     */
    public function get_all_bank_payouts(): array
    {
        return $this->bank_payout()->all();
    }

    /*
    |--------------------------------------------------------------------------
    | Bill Payments & Airtime Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get all supported billers.
     *
     * @return array The list of billers.
     */
    public function get_billers(): array
    {
        return $this->bill()->getBillers();
    }

    /**
     * Get details for a specific biller.
     *
     * @param  string  $billerId  The biller ID.
     * @return array The biller details.
     */
    public function get_biller_details(string $billerId): array
    {
        return $this->bill()->getBillerDetails($billerId);
    }

    /**
     * Validate a bill before payment.
     *
     * @param  array  $data  The bill validation data.
     * @return array The validation result.
     */
    public function validate_bill(array $data): array
    {
        return $this->bill()->validate($data);
    }

    /**
     * Pay a bill.
     *
     * @param  array  $data  The payment details.
     * @return array The API response.
     */
    public function pay_bill(array $data): array
    {
        return $this->bill()->pay($data);
    }

    /**
     * Recharge airtime.
     *
     * @param  array  $data  The airtime recharge details.
     * @return array The API response.
     */
    public function buy_airtime(array $data): array
    {
        return $this->airtime()->create($data);
    }

    /**
     * Get bill transaction details.
     *
     * @param  string  $reference  The transaction reference.
     * @return array The transaction details.
     */
    public function get_bill_transaction(string $reference): array
    {
        return $this->bill()->getTransactionDetails($reference);
    }

    /**
     * Get bill statistics.
     *
     * @return array The bill statistics.
     */
    public function get_bill_statistics(): array
    {
        return $this->bill()->getStatistics();
    }

    /*
    |--------------------------------------------------------------------------
    | Direct Charge (Bank Transfer) Methods
    |--------------------------------------------------------------------------
    */

    public function checkout(): Checkout
    {
        // Constructed as: https://api.paychangu.com/payment
        $url = $this->apiBaseUrl.'payment';
        $client = new Client($this->privateKey, $url);

        return new Checkout($client);
    }

    public function mobile_money(): MobileMoney
    {
        // Constructed as: https://api.paychangu.com/mobile-money/
        $url = $this->apiBaseUrl.'mobile-money/';
        $client = new Client($this->privateKey, $url);

        return new MobileMoney($client);
    }

    public function direct_charge(): DirectCharge
    {
        // Constructed as: https://api.paychangu.com/direct-charge/
        $url = $this->apiBaseUrl.'direct-charge/';
        $client = new Client($this->privateKey, $url);

        return new DirectCharge($client);
    }

    public function card(): Card
    {
        // Constructed as: https://api.paychangu.com/charge-card/
        $url = $this->apiBaseUrl.'charge-card/';
        $client = new Client($this->privateKey, $url);

        return new Card($client);
    }

    public function mobile_money_payout(): MobileMoneyPayout
    {
        // Constructed as: https://api.paychangu.com/mobile-money/
        $url = $this->apiBaseUrl.'mobile-money/';
        $client = new Client($this->privateKey, $url);

        return new MobileMoneyPayout($client);
    }

    public function bank_payout(): BankPayout
    {
        // Constructed as: https://api.paychangu.com/direct-charge/
        $url = $this->apiBaseUrl.'direct-charge/';
        $client = new Client($this->privateKey, $url);

        return new BankPayout($client);
    }

    public function bill(): Bill
    {
        // Constructed as: https://api.paychangu.com/bills/
        $url = $this->apiBaseUrl.'bills/';
        $client = new Client($this->privateKey, $url);

        return new Bill($client);
    }

    public function airtime(): Airtime
    {
        // Constructed as: https://api.paychangu.com/bills/
        // Airtime endpoints are also under /bills/
        $url = $this->apiBaseUrl.'bills/';
        $client = new Client($this->privateKey, $url);

        return new Airtime($client);
    }

    public function verification(): Verification
    {
        // Verification typically uses the payment/checkout base
        $url = $this->apiBaseUrl.'payment';
        $client = new Client($this->privateKey, $url);

        return new Verification($client);
    }
}
