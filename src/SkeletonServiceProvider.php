<?php

namespace Spatie\Skeleton;

use Illuminate\Support\ServiceProvider;
use Spatie\Skeleton\Commands\SkeletonCommand;

class SkeletonServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/skeleton.php' => config_path('skeleton.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/skeleton'),
            ], 'views');

            if (! class_exists('CreatePackageTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_skeleton_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_skeleton_table.php'),
                ], 'migrations');
            }

            $this->commands([
                SkeletonCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'skeleton');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/skeleton.php', 'skeleton');
    }
}
