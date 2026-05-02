<?php

namespace Matheusmarnt\LiveCharts\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Matheusmarnt\LiveCharts\LiveCharts
 */
class LiveCharts extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Matheusmarnt\LiveCharts\LiveCharts::class;
    }
}
