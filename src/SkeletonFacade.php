<?php

namespace Spatie\Skeleton;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\Skeleton\Skeleton
 */
class SkeletonFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'skeleton';
    }
}
