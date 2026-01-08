<?php

declare(strict_types=1);

namespace Paychangu\Laravel\Resources\BillPayments;

use InvalidArgumentException;
use Paychangu\Laravel\Resources\BaseResource;

class Bill extends BaseResource
{
    /**
     * Get all supported billers.
     *
     * @return array The list of billers.
     */
    public function getBillers(): array
    {
        $response = $this->client->get('getBillers');

        if (isset($response['status']) && $response['status'] === 'success') {
            return [
                'success' => true,
                'data' => $response['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $response['message'] ?? 'Failed to fetch billers',
            'original_response' => $response,
        ];
    }

    /**
     * Get details for a specific biller.
     *
     * @param  string  $billerId  The biller ID.
     * @return array The biller details.
     *
     * @throws InvalidArgumentException
     */
    public function getBillerDetails(string $billerId): array
    {
        if (empty($billerId)) {
            throw new InvalidArgumentException('Biller ID cannot be empty.');
        }

        $response = $this->client->get("getBillers/{$billerId}");

        if (isset($response['status']) && $response['status'] === 'success') {
            return [
                'success' => true,
                'data' => $response['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $response['message'] ?? 'Failed to fetch biller details',
            'original_response' => $response,
        ];
    }

    /**
     * Validate a bill before payment.
     *
     * @param  array  $data  The bill validation data.
     * @return array The validation result.
     *
     * @throws InvalidArgumentException
     */
    public function validate(array $data): array
    {
        $requiredKeys = ['biller', 'account'];
        foreach ($requiredKeys as $key) {
            if (empty($data[$key])) {
                throw new InvalidArgumentException("Missing required field: {$key}");
            }
        }

        $response = $this->client->post('validate', $data);

        if (isset($response['status']) && $response['status'] === 'success') {
            return [
                'success' => true,
                'data' => $response['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $response['message'] ?? 'Bill validation failed',
            'original_response' => $response,
        ];
    }

    /**
     * Pay a bill.
     *
     * @param  array  $data  The payment details.
     * @return array The API response.
     *
     * @throws InvalidArgumentException
     */
    public function pay(array $data): array
    {
        $requiredKeys = ['biller', 'account', 'amount', 'reference'];
        foreach ($requiredKeys as $key) {
            if (empty($data[$key])) {
                throw new InvalidArgumentException("Missing required field: {$key}");
            }
        }

        $response = $this->client->post('pay', $data);

        if (isset($response['status']) && $response['status'] === 'success') {
            return [
                'success' => true,
                'data' => $response['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $response['message'] ?? 'Bill payment failed',
            'original_response' => $response,
        ];
    }

    /**
     * Get bill transaction details.
     *
     * @param  string  $reference  The transaction reference.
     * @return array The transaction details.
     *
     * @throws InvalidArgumentException
     */
    public function getTransactionDetails(string $reference): array
    {
        if (empty($reference)) {
            throw new InvalidArgumentException('Reference cannot be empty.');
        }

        $response = $this->client->get("getTransactions/{$reference}");

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

    /**
     * Get bill statistics.
     *
     * @return array The bill statistics.
     */
    public function getStatistics(): array
    {
        $response = $this->client->get('getStatistics');

        if (isset($response['status']) && $response['status'] === 'success') {
            return [
                'success' => true,
                'data' => $response['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $response['message'] ?? 'Failed to fetch statistics',
            'original_response' => $response,
        ];
    }
}
