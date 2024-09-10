<?php

namespace IdrissaNdiouck\LaravelWolof\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \IdrissaNdiouck\LaravelWolof\LaravelWolof
 */
class LaravelWolof extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \IdrissaNdiouck\LaravelWolof\LaravelWolof::class;
    }
}
