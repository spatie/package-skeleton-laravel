<?php

namespace Mzati\Paychangu\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Exception;

class Client
{
    protected GuzzleClient $client;
    protected string $baseUrl;
    protected string $secretKey;

    public function __construct(string $secretKey, string $baseUrl)
    {
        $this->secretKey = $secretKey;
        $this->baseUrl = rtrim($baseUrl, '/');

        $this->client = new GuzzleClient([
            'base_uri' => $this->baseUrl . '/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Send a GET request.
     *
     * @param string $path
     * @param array $query
     * @return array
     * @throws Exception
     */
    public function get(string $path, array $query = []): array
    {
        return $this->request('GET', $path, ['query' => $query]);
    }

    /**
     * Send a POST request.
     *
     * @param string $path
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function post(string $path, array $data = []): array
    {
        return $this->request('POST', $path, ['json' => $data]);
    }

    /**
     * Send a PUT request.
     *
     * @param string $path
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function put(string $path, array $data = []): array
    {
        return $this->request('PUT', $path, ['json' => $data]);
    }

    /**
     * Execute the request and normalize the response.
     *
     * @param string $method
     * @param string $path
     * @param array $options
     * @return array
     * @throws Exception
     */
    protected function request(string $method, string $path, array $options = []): array
    {
        try {
            // Remove leading slash to append correctly to base_uri
            $path = ltrim($path, '/');
            
            $response = $this->client->request($method, $path, $options);
            $content = $response->getBody()->getContents();
            
            return json_decode($content, true) ?? [];
        } catch (GuzzleException $e) {
            // If Guzzle throws an exception (e.g. 4xx/5xx), try to decode the response body for API errors
            if ($e->hasResponse()) {
                $responseBody = $e->getResponse()->getBody()->getContents();
                $errorData = json_decode($responseBody, true);
                
                $message = $errorData['message'] ?? $e->getMessage();
                throw new Exception("PayChangu API Error: {$message}", $e->getCode(), $e);
            }
            
            throw new Exception("PayChangu Connection Error: " . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
