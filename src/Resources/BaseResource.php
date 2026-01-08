<?php

namespace Paychangu\Laravel\Resources;

use Paychangu\Laravel\Http\Client;

abstract class BaseResource
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
