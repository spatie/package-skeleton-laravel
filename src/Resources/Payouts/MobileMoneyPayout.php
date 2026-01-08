<?php

declare(strict_types=1);

namespace Mzati\Paychangu\Resources\Payouts;

use InvalidArgumentException;
use Mzati\Paychangu\Resources\BaseResource;

class MobileMoneyPayout extends BaseResource
{
    /**
     * Get all mobile money operators.
     *
     * @return array The list of operators.
     */
    public function getOperators(): array
    {
        $response = $this->client->get('');

        if (isset($response['status']) && $response['status'] === 'success') {
            return [
                'success' => true,
                'data' => $response['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $response['message'] ?? 'Failed to fetch operators',
        ];
    }

    /**
     * Initialize a mobile money payout.
     *
     * @param  array  $data  The payout details.
     * @return array The API response.
     * @throws InvalidArgumentException
     */
    public function create(array $data): array
    {
        $requiredKeys = ['mobile', 'mobile_money_operator_ref_id', 'amount', 'charge_id'];
        foreach ($requiredKeys as $key) {
            if (empty($data[$key])) {
                throw new InvalidArgumentException("Missing required field: {$key}");
            }
        }

        $response = $this->client->post('payouts/initialize', $data);

        if (isset($response['status']) && $response['status'] === 'success') {
            return [
                'success' => true,
                'data' => $response['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $response['message'] ?? 'Mobile money payout initialization failed',
            'original_response' => $response,
        ];
    }

    /**
     * Get details of a mobile money payout (charge).
     *
     * @param  string  $chargeId  The charge ID.
     * @return array The payout details.
     * @throws InvalidArgumentException
     */
    public function details(string $chargeId): array
    {
        if (empty($chargeId)) {
            throw new InvalidArgumentException('Charge ID cannot be empty.');
        }

        $response = $this->client->get("payments/{$chargeId}/details");

        if (isset($response['status']) && $response['status'] === 'success') {
            return [
                'success' => true,
                'data' => $response['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $response['message'] ?? 'Failed to fetch payout details',
            'original_response' => $response,
        ];
    }
}
