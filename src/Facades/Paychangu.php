<?php

namespace Mzati\Paychangu\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mzati\Paychangu\Paychangu
 */
class Paychangu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'paychangu';
    }
}
