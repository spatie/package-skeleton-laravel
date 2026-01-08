<?php

declare(strict_types=1);

namespace Paychangu\Laravel\Resources\Payouts;

use InvalidArgumentException;
use Paychangu\Laravel\Resources\BaseResource;

class BankPayout extends BaseResource
{
    /**
     * Get supported banks for payouts.
     *
     * @param  string  $currency  The currency code.
     * @return array The list of supported banks.
     */
    public function getSupportedBanks(string $currency = 'MWK'): array
    {
        $response = $this->client->get("payouts/supported-banks?currency={$currency}");

        if (isset($response['status']) && $response['status'] === 'success') {
            return [
                'success' => true,
                'data' => $response['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $response['message'] ?? 'Failed to fetch supported banks',
            'original_response' => $response,
        ];
    }

    /**
     * Initialize a bank payout.
     *
     * @param  array  $data  The payout details.
     * @return array The API response.
     *
     * @throws InvalidArgumentException
     */
    public function create(array $data): array
    {
        $requiredKeys = ['bank_uuid', 'amount', 'charge_id', 'bank_account_name', 'bank_account_number'];
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
            'error' => $response['message'] ?? 'Bank payout initialization failed',
            'original_response' => $response,
        ];
    }

    /**
     * Get details of a bank payout.
     *
     * @param  string  $chargeId  The charge ID.
     * @return array The payout details.
     *
     * @throws InvalidArgumentException
     */
    public function details(string $chargeId): array
    {
        if (empty($chargeId)) {
            throw new InvalidArgumentException('Charge ID cannot be empty.');
        }

        $response = $this->client->get("payouts/{$chargeId}/details");

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

    /**
     * Get all bank payouts.
     *
     * @return array The list of all bank payouts.
     */
    public function all(): array
    {
        $response = $this->client->get('payouts');

        if (isset($response['status']) && $response['status'] === 'success') {
            return [
                'success' => true,
                'data' => $response['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $response['message'] ?? 'Failed to fetch payouts',
            'original_response' => $response,
        ];
    }
}
