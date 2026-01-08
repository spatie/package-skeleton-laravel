<?php

namespace Mzati\Paychangu;

use Mzati\Paychangu\Http\Client;
use Mzati\Paychangu\Resources\Payment;
use Mzati\Paychangu\Resources\Transaction;

class Paychangu
{
    protected Client $client;

    public function __construct()
    {
        $privateKey = config('paychangu.private_key') ?? '';
        $paymentUrl = config('paychangu.payment_url') ?? '';

        $this->client = new Client($privateKey, $paymentUrl);
    }

    /**
     * Get the payment resource.
     */
    public function payments(): Payment
    {
        return new Payment($this->client);
    }

    /**
     * Get the transaction resource.
     */
    public function transactions(): Transaction
    {
        return new Transaction($this->client);
    }
}
