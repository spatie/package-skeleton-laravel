<?php

namespace Spatie\Skeleton;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\Skeleton\SkeletonClass
 */
class SkeletonFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'skeleton';
    }
}
