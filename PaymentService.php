<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class PaymentService
{
    private Client $client;

    private string $apiUrl;

    private string $returnUrl;

    private string $callbackUrl;

    private string $verifyUrl;

    public function __construct()
    {
        $this->client = new Client;
        $this->apiUrl = config('services.paychangu.api_url');
        $this->verifyUrl = config('services.paychangu.verify_url');
        // Use dynamic routes instead of static URLs
        $this->returnUrl = route('payment.return', [], true);
        $this->callbackUrl = route('payment.callback', [], true);
    }

    /**
     * Initialize a payment with PayChangu
     *
     * @param  array  $paymentData  ['amount', 'currency', 'first_name', 'last_name', 'email', 'meta']
     */
    public function initialize(array $paymentData): array
    {
        try {
            $mode = config('services.paychangu.mode', 'test');
            $secretKey = $mode === 'live'
                ? config('services.paychangu.live_secret_key')
                : config('services.paychangu.test_secret_key');

            if (empty($secretKey)) {
                $keyType = $mode === 'live' ? 'PAYCHANGU_LIVE_SECRET_KEY' : 'PAYCHANGU_TEST_SECRET_KEY';

                // For development/testing purposes, provide a helpful error message
                if (app()->environment('local', 'testing')) {
                    throw new Exception("Missing {$keyType} in environment. Please add it to your .env file. Run 'php artisan paychangu:setup' for help.");
                }

                throw new Exception("Missing {$keyType} in environment.");
            }

            $txRef = $this->generateTransactionReference();
            $uuid = Str::uuid()->toString();

            // Prepare meta data including agenda and customization
            $metaData = $paymentData['meta'] ?? [];
            if (isset($paymentData['agenda'])) {
                $metaData['agenda'] = $paymentData['agenda'];
            }
            if (isset($paymentData['customization'])) {
                $metaData['customization'] = $paymentData['customization'];
            }

            $payload = [
                'currency' => 'MWK',
                'uuid' => $uuid,
                'tx_ref' => $txRef,
                'amount' => $paymentData['amount'],
                'first_name' => $paymentData['first_name'],
                'last_name' => $paymentData['last_name'],
                'email' => $paymentData['email'],
                'return_url' => $this->returnUrl,
                'callback_url' => $this->callbackUrl,
                'meta' => $metaData,
            ];

            $response = $this->client->post($this->apiUrl, [
                'body' => json_encode($payload),
                'headers' => [
                    'Authorization' => 'Bearer '.$secretKey,
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ],
            ]);

            $responseData = json_decode($response->getBody(), true);

            if (isset($responseData['status']) && $responseData['status'] === 'success') {
                return [
                    'success' => true,
                    'checkout_url' => $responseData['data']['checkout_url'],
                    'tx_ref' => $responseData['data']['data']['tx_ref'],
                    'amount' => $responseData['data']['data']['amount'],
                    'currency' => $responseData['data']['data']['currency'],
                ];
            }

            return [
                'success' => false,
                'error' => $responseData['message'] ?? 'Payment initialization failed',
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => 'Request failed: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Verify a transaction with PayChangu
     *
     * @param  array  $transactionData  ['tx_ref'] - transaction reference to verify
     */
    public function verifyTransaction(array $transactionData): array
    {
        try {
            $mode = config('services.paychangu.mode', 'test');
            $secretKey = $mode === 'live'
                ? config('services.paychangu.live_secret_key')
                : config('services.paychangu.test_secret_key');

            if (empty($secretKey)) {
                $keyType = $mode === 'live' ? 'PAYCHANGU_LIVE_SECRET_KEY' : 'PAYCHANGU_TEST_SECRET_KEY';

                // For development/testing purposes, provide a helpful error message
                if (app()->environment('local', 'testing')) {
                    throw new Exception("Missing {$keyType} in environment. Please add it to your .env file. Run 'php artisan paychangu:setup' for help.");
                }

                throw new Exception("Missing {$keyType} in environment.");
            }

            if (empty($transactionData['tx_ref'])) {
                throw new Exception('Transaction reference (tx_ref) is required.');
            }

            $verifyEndpoint = $this->verifyUrl.'/'.$transactionData['tx_ref'];

            $response = $this->client->get($verifyEndpoint, [
                'headers' => [
                    'Authorization' => 'Bearer '.$secretKey,
                    'accept' => 'application/json',
                ],
            ]);

            $responseData = json_decode($response->getBody(), true);

            if (isset($responseData['status']) && $responseData['status'] === 'success') {
                return [
                    'success' => true,
                    'data' => $responseData['data'],
                ];
            }

            return [
                'success' => false,
                'error' => $responseData['message'] ?? 'Transaction verification failed',
                'data' => $responseData['data'] ?? null,
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => 'Verification request failed: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Generate a unique transaction reference
     */
    private function generateTransactionReference(): string
    {
        return 'TXN_'.now()->timestamp.'_'.mt_rand(1000, 9999);
    }
}
