<?php

namespace BabaluCommunity\Skeleton;

use BabaluCommunity\Skeleton\Commands\SkeletonCommand;
use BabaluCommunity\Skeleton\Overrides\InstallCommandOverride;
use BabaluCommunity\Skeleton\Overrides\PackageOverride;
use BabaluCommunity\Skeleton\Overrides\PackageServiceProviderOverride;

/**
 * The `BabaluCommunity\Skeleton\SkeletonServiceProvider` class is a service provider for a Laravel package. It
 * extends the `PackageServiceProviderOverride` class and configures various
 * aspects of the package, such as setting the package name, defining routes,
 * handling translations, configurations, views, assets, and commands related
 * to the package installation. It also defines the behavior of the
 * `skeleton:install` command by specifying actions to be taken during
 * the installation process, such as publishing configuration files, assets,
 * Inertia components, views, and registering service providers in the app.
 */
class SkeletonServiceProvider extends PackageServiceProviderOverride
{
    public function configurePackage(PackageOverride $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('skeleton')
            // ->hasRoutes(['web-skeleton', 'auth-skeleton', 'admin-skeleton'])
            ->hasRoute('web-skeleton')
            // `php artisan vendor:publish --tag=skeleton-translations`
            ->hasTranslations()
            ->hasConfigFile()
            // `php artisan vendor:publish --tag=skeleton-views`
            ->hasViews()
            ->sharesDataWithAllViews('companyName', 'IAmAI - Babalu')
            // TODO: CONSIDER MAKING THIS A CONTRIBUTION, IT SHOULD EXIST. 2023-10-28 11:13 AM - JJ
            // `php artisan vendor:publish --tag=skeleton-inertia-components`
            ->hasInertiaComponents()
            // copy over the Public `skeleton/resources/dist/` assets to the `public/vendor/skeleton` directory
            ->hasAssets()
            // ->hasMigration('create_skeleton_table')
            ->publishesServiceProvider('SkeletonServiceProvider')
            ->hasCommand(SkeletonCommand::class)
            // Install this package with the following command:
            // `php artisan skeleton:install`
            ->hasInstallCommand(function (InstallCommandOverride $command) {
                $command
                    ->startWith(function (InstallCommandOverride $command) {
                        $command->info('Initializing Skeleton Title Package installation.');
                    })
                    // `php artisan vendor:publish --tag=skeleton-config`
                    ->publishConfigFile()
                    // `php artisan vendor:publish --tag=skeleton-assets`
                    ->publishAssets()
                    // `php artisan vendor:publish --tag=skeleton-inertia-components`
                    ->publishInertiaComponents()
                    // `php artisan vendor:publish --tag=skeleton-inertia-views`
                    ->publishViews()
                    // `php artisan vendor:publish --tag=skeleton-migrations`
                    // ->publishMigrations()
                    // ->askToRunMigrations()
                    // copy /resources/stubs/{$nameOfYourServiceProvider}.php.stub in your package to app/Providers/{$nameOfYourServiceProvider}.php in the app
                    // `php artisan vendor:publish --tag=skeleton-provider`
                    ->copyAndRegisterServiceProviderInApp()
                    ->askToStarRepoOnGitHub('babalu-community/skeleton')
                    ->endWith(function (InstallCommandOverride $command) {
                        $command->info('Skeleton Title Package installation Complete!');
                    });
            });
    }
}
