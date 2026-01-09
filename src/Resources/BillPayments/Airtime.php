<?php

declare(strict_types=1);

namespace Paychangu\Laravel\Resources\BillPayments;

use InvalidArgumentException;
use Paychangu\Laravel\Resources\BaseResource;

class Airtime extends BaseResource
{
    /**
     * Recharge airtime (TNM/Airtel).
     *
     * @param  array  $data  The airtime recharge details.
     * @return array The API response.
     *
     * @throws InvalidArgumentException
     */
    public function create(array $data): array
    {
        $requiredKeys = ['phone', 'amount'];
        foreach ($requiredKeys as $key) {
            if (empty($data[$key])) {
                throw new InvalidArgumentException("Missing required field: {$key}");
            }
        }

        $response = $this->client->post('buy-airtime', $data);

        if (isset($response['status']) && $response['status'] === 'success') {
            return [
                'success' => true,
                'data' => $response['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $response['message'] ?? 'Airtime recharge failed',
            'original_response' => $response,
        ];
    }
}
