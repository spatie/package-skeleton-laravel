<?php

declare(strict_types=1);

namespace Paychangu\Laravel\Resources\Banks;

use InvalidArgumentException;
use Paychangu\Laravel\Resources\BaseResource;

class DirectCharge extends BaseResource
{
    /**
     * Initiate a direct charge (Bank Transfer).
     *
     * @param  array  $data  The charge details.
     * @return array The API response.
     *
     * @throws InvalidArgumentException
     */
    public function create(array $data): array
    {
        $requiredKeys = ['currency', 'amount', 'charge_id'];
        foreach ($requiredKeys as $key) {
            if (empty($data[$key])) {
                throw new InvalidArgumentException("Missing required field: {$key}");
            }
        }

        $response = $this->client->post('payments/initialize', $data);

        if (isset($response['status']) && $response['status'] === 'success') {
            return [
                'success' => true,
                'data' => $response['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $response['message'] ?? 'Direct charge initialization failed',
            'original_response' => $response,
        ];
    }

    /**
     * Verify a direct charge transaction.
     *
     * @param  string  $chargeId  The charge ID.
     * @return array The transaction details.
     *
     * @throws InvalidArgumentException
     */
    public function details(string $chargeId): array
    {
        if (empty($chargeId)) {
            throw new InvalidArgumentException('Charge ID cannot be empty.');
        }

        $response = $this->client->get("transactions/{$chargeId}/details");

        if (isset($response['status']) && $response['status'] === 'success') {
            return [
                'success' => true,
                'data' => $response['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $response['message'] ?? 'Failed to fetch transaction details',
            'original_response' => $response,
        ];
    }
}
