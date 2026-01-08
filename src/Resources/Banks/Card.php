<?php

declare(strict_types=1);

namespace Mzati\Paychangu\Resources\Banks;

use InvalidArgumentException;
use Mzati\Paychangu\Resources\BaseResource;

class Card extends BaseResource
{
    /**
     * Charge a card.
     *
     * @param  array  $data  The card and charge details.
     * @return array The API response.
     * @throws InvalidArgumentException
     */
    public function create(array $data): array
    {
        $requiredKeys = [
            'card_number', 'expiry', 'cvv', 'cardholder_name', 
            'amount', 'currency', 'charge_id', 'redirect_url'
        ];
        foreach ($requiredKeys as $key) {
            if (empty($data[$key])) {
                throw new InvalidArgumentException("Missing required field: {$key}");
            }
        }

        $response = $this->client->post('payments', $data);

        if (isset($response['status']) && $response['status'] === 'success') {
            return [
                'success' => true,
                'data' => $response['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $response['message'] ?? 'Card charge failed',
            'original_response' => $response,
        ];
    }

    /**
     * Verify a card charge.
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

        $response = $this->client->get("verify/{$chargeId}");

        if (isset($response['status']) && $response['status'] === 'success') {
            return [
                'success' => true,
                'data' => $response['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $response['message'] ?? 'Card charge verification failed',
            'original_response' => $response,
        ];
    }

    /**
     * Refund a card charge.
     *
     * @param  string  $chargeId  The charge ID.
     * @return array The refund result.
     * @throws InvalidArgumentException
     */
    public function refund(string $chargeId): array
    {
        if (empty($chargeId)) {
            throw new InvalidArgumentException('Charge ID cannot be empty.');
        }

        $response = $this->client->post("refund/{$chargeId}", []);

        if (isset($response['status']) && $response['status'] === 'success') {
            return [
                'success' => true,
                'data' => $response['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $response['message'] ?? 'Card charge refund failed',
            'original_response' => $response,
        ];
    }
}
