<?php

declare(strict_types=1);

namespace Paychangu\Laravel\Resources;

use Illuminate\Support\Str;
use InvalidArgumentException;

class Checkout extends BaseResource
{
    /**
     * Initialize a new checkout payment (Hosted Page).
     *
     * @param  array  $data  The checkout data (amount, email, etc.).
     * @return array The API response containing the checkout URL.
     *
     * @throws InvalidArgumentException
     */
    public function create(array $data): array
    {
        $requiredKeys = ['amount', 'callback_url', 'return_url'];
        foreach ($requiredKeys as $key) {
            if (empty($data[$key])) {
                throw new InvalidArgumentException("Missing required field: {$key}");
            }
        }

        $txRef = 'TXN_'.now()->timestamp.'_'.mt_rand(1000, 9999);
        $uuid = Str::uuid()->toString();

        $metaData = $data['meta'] ?? [];
        if (isset($data['agenda'])) {
            $metaData['agenda'] = $data['agenda'];
        }

        $payload = [
            'currency' => $data['currency'] ?? 'MWK',
            'uuid' => $uuid,
            'tx_ref' => $txRef,
            'amount' => $data['amount'],
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'email' => $data['email'] ?? null,
            'return_url' => $data['return_url'],
            'callback_url' => $data['callback_url'],
            'meta' => $metaData,
            'customization' => $data['customization'] ?? null,
        ];

        $payload = array_filter($payload, fn ($value) => ! is_null($value));

        $response = $this->client->post('', $payload);

        if (isset($response['status']) && $response['status'] === 'success') {
            return [
                'success' => true,
                'checkout_url' => $response['data']['checkout_url'] ?? null,
                'tx_ref' => $response['data']['data']['tx_ref'] ?? $txRef,
                'amount' => $response['data']['data']['amount'] ?? $data['amount'],
                'currency' => $response['data']['data']['currency'] ?? ($data['currency'] ?? 'MWK'),
                'original_response' => $response,
            ];
        }

        return [
            'success' => false,
            'error' => $response['message'] ?? 'Payment initialization failed',
            'original_response' => $response,
        ];
    }
}
