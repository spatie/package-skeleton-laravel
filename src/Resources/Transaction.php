<?php

namespace Mzati\Paychangu\Resources;

class Transaction extends BaseResource
{
    /**
     * Verify a transaction by its reference.
     *
     * @param string $txRef
     * @return array
     */
    public function verify(string $txRef): array
    {
        // Constructed as PAYCHANGU_PAYMENT_URL/verify/{txRef}
        $response = $this->client->get("verify/{$txRef}");

        if (isset($response['status']) && $response['status'] === 'success') {
            return [
                'success' => true,
                'data' => $response['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $response['message'] ?? 'Transaction verification failed',
            'data' => $response['data'] ?? null,
        ];
    }
}
