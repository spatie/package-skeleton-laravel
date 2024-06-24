<?php

namespace VendorName\Skeleton\Overrides;

use Spatie\LaravelPackageTools\Commands\InstallCommand;

class InstallCommandOverride extends InstallCommand
{
    /**
     * The `publishViews` function in PHP publishes views.
     *  Called by `packages/babalu-community/backend-blog/src/SkeletonServiceProvider.php:77`
     *
     * @return self The `publishViews()` method is returning the result of calling the `publish()`
     *              method with the argument `'views'`.
     */
    public function publishViews(): self
    {
        return $this->publish('views');
    }
}
