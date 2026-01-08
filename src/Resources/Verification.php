<?php

declare(strict_types=1);

namespace Paychangu\Laravel\Resources;

use InvalidArgumentException;

class Verification extends BaseResource
{
    /**
     * Verify a transaction by its reference.
     *
     * @throws InvalidArgumentException
     */
    public function verify(string $txRef): array
    {
        if (empty($txRef)) {
            throw new InvalidArgumentException('Transaction reference cannot be empty.');
        }

        $txRef = strip_tags($txRef);

        $response = $this->client->get("verify-payment/{$txRef}");

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
