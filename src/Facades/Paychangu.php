<?php

namespace Paychangu\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Paychangu\Laravel\Paychangu
 */
class Paychangu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'paychangu';
    }
}
