<?php

declare(strict_types=1);

namespace Paychangu\Laravel\Resources\MobileMoney;

use InvalidArgumentException;
use Paychangu\Laravel\Resources\BaseResource;

class MobileMoney extends BaseResource
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
     * Charge a mobile money account directly.
     *
     * @param  array  $data  The charge details.
     * @return array The API response.
     * @throws InvalidArgumentException
     */
    public function charge(array $data): array
    {
        $requiredKeys = ['mobile_money_operator_ref_id', 'mobile', 'amount', 'charge_id'];
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
            'error' => $response['message'] ?? 'Mobile money charge failed',
            'original_response' => $response,
        ];
    }

    /**
     * Verify a mobile money payment.
     *
     * @param  string  $chargeId  The charge ID.
     * @return array The verification result.
     * @throws InvalidArgumentException
     */
    public function verify(string $chargeId): array
    {
        if (empty($chargeId)) {
            throw new InvalidArgumentException('Charge ID cannot be empty.');
        }

        $response = $this->client->get("payments/{$chargeId}/verify");

        if (isset($response['status']) && $response['status'] === 'success') {
            return [
                'success' => true,
                'data' => $response['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $response['message'] ?? 'Verification failed',
            'data' => $response['data'] ?? null,
        ];
    }

    /**
     * Get details of a single mobile money payment.
     *
     * @param  string  $chargeId  The charge ID.
     * @return array The payment details.
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
            'error' => $response['message'] ?? 'Failed to fetch details',
            'data' => $response['data'] ?? null,
        ];
    }
}
