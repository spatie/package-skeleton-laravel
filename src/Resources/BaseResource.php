<?php

namespace Mzati\Paychangu\Resources;

use Mzati\Paychangu\Http\Client;

abstract class BaseResource
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
