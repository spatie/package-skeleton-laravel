<?php

namespace VendorName\Skeleton\Overrides;

require __DIR__.'/PackageOverride.php';

use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider as ServiceProviderBlog;
use Illuminate\Support\Str;
use ReflectionClass;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

abstract class PackageServiceProviderOverride extends ServiceProviderBlog
{
    protected PackageOverride $package;

    // We couldn't really override the existing class in this case, because of the strict signature typing in the abstract method. since the parameter was also overridden, the entire class needed to be overridden instead of inherited.

    // When inheriting from an abstract class, all methods marked abstract in the parent's class declaration must be defined by the child; additionally, these methods must be defined with the same (or a less restricted) visibility. For example, if the abstract method is defined as protected, the function implementation must be defined as either protected or public, but not private. Furthermore the signatures of the methods must match
    abstract public function configurePackage(PackageOverride $package): void;

    public function boot()
    {
        $this->bootingPackage();

        if ($this->package->hasTranslations) {
            $langPath = 'vendor/'.$this->package->shortName();

            $langPath = (function_exists('lang_path'))
                ? lang_path($langPath)
                : resource_path('lang/'.$langPath);
        }

        if ($this->app->runningInConsole()) {
            foreach ($this->package->configFileNames as $configFileName) {
                $this->publishes([
                    $this->package->basePath("/../config/{$configFileName}.php") => config_path("{$configFileName}.php"),
                ], "{$this->package->shortName()}-config");
            }

            if ($this->package->hasViews) {
                $this->publishes([
                    $this->package->basePath('/../resources/views') => resource_path("views/vendor/{$this->packageView($this->package->viewNamespace)}"),
                ], "{$this->packageView($this->package->viewNamespace)}-views");
            }

            // overridden to support css as part of inertia deps
            if ($this->package->hasInertiaComponents) {
                $this->publishes([
                    $this->package->basePath('/../resources/js') => resource_path("js/vendor/{$this->package->shortName()}"),
                ], "{$this->package->shortName()}-inertia-components");
                $this->publishes([
                    $this->package->basePath('/../resources/css') => resource_path("css/vendor/{$this->package->shortName()}"),
                ], "{$this->package->shortName()}-inertia-components");
            }

            $now = Carbon::now();
            foreach ($this->package->migrationFileNames as $migrationFileName) {
                $filePath = $this->package->basePath("/../database/migrations/{$migrationFileName}.php");
                if (! file_exists($filePath)) {
                    // Support for the .stub file extension
                    $filePath .= '.stub';
                }

                $this->publishes([
                    $filePath => $this->generateMigrationName(
                        $migrationFileName,
                        $now->addSecond()
                    ), ], "{$this->package->shortName()}-migrations");

                if ($this->package->runsMigrations) {
                    $this->loadMigrationsFrom($filePath);
                }
            }

            if ($this->package->hasTranslations) {
                $this->publishes([
                    $this->package->basePath('/../resources/lang') => $langPath,
                ], "{$this->package->shortName()}-translations");
            }

            if ($this->package->hasAssets) {
                $this->publishes([
                    $this->package->basePath('/../resources/dist') => public_path("vendor/{$this->package->shortName()}"),
                ], "{$this->package->shortName()}-assets");
            }

            // both publish and load routes; published version for app instance overrides
            // ? to support monolithic dev during package buildout
            // ! should be removed once cicd is in place - JJ 2024-06-13 04:27 PM
            foreach ($this->package->routeFileNames as $routeFileName) {
                $this->publishes([
                    $this->package->basePath('/../routes') => app_path("routes/vendor/{$this->package->shortName()}"),
                ], "{$this->package->shortName()}-routes");
            }

            //     if ($this->package->hasInertiaComponents) {
            //         $this->publishes([
            //             $this->package->basePath('/../resources/js') => resource_path("js/vendor/{$this->package->shortName()}"),
            //         ], "{$this->package->shortName()}-inertia-components");
            //         $this->publishes([
            //             $this->package->basePath('/../resources/css') => resource_path("css/vendor/{$this->package->shortName()}"),
            //         ], "{$this->package->shortName()}-inertia-components");
            //     }
        }

        if (! empty($this->package->commands)) {
            $this->commands($this->package->commands);
        }

        if (! empty($this->package->consoleCommands) && $this->app->runningInConsole()) {
            $this->commands($this->package->consoleCommands);
        }

        if ($this->package->hasTranslations) {
            $this->loadTranslationsFrom(
                $this->package->basePath('/../resources/lang/'),
                $this->package->shortName()
            );

            $this->loadJsonTranslationsFrom($this->package->basePath('/../resources/lang/'));

            $this->loadJsonTranslationsFrom($langPath);
        }

        if ($this->package->hasViews) {
            $this->loadViewsFrom($this->package->basePath('/../resources/views'), $this->package->viewNamespace());
        }

        foreach ($this->package->viewComponents as $componentClass => $prefix) {
            $this->loadViewComponentsAs($prefix, [$componentClass]);
        }

        if (count($this->package->viewComponents)) {
            $this->publishes([
                $this->package->basePath('/Components') => base_path("app/View/Components/vendor/{$this->package->shortName()}"),
            ], "{$this->package->name}-components");
        }

        if ($this->package->publishableProviderName) {
            $this->publishes([
                $this->package->basePath("/../resources/stubs/{$this->package->publishableProviderName}.php.stub") => base_path("app/Providers/{$this->package->publishableProviderName}.php"),
            ], "{$this->package->shortName()}-provider");
        }

        foreach ($this->package->routeFileNames as $routeFileName) {
            $this->loadRoutesFrom("{$this->package->basePath('/../routes/')}{$routeFileName}.php");
        }

        foreach ($this->package->sharedViewData as $name => $value) {
            View::share($name, $value);
        }

        foreach ($this->package->viewComposers as $viewName => $viewComposer) {
            View::composer($viewName, $viewComposer);
        }

        $this->packageBooted();

        return $this;
    }

    public function register()
    {
        $this->registeringPackage();

        $this->package = $this->newPackage();
        // The `src` dir is the package base dir; of which are all subdirectories: Commands, Facades, Http/Controllers, Models, Overrides, Providers, and Traits
        $this->package->setBasePath($this->getPackageBaseDir());

        $this->configurePackage($this->package);

        if (empty($this->package->name)) {
            throw InvalidPackage::nameIsRequired();
        }

        foreach ($this->package->configFileNames as $configFileName) {
            $this->mergeConfigFrom($this->package->basePath("/../config/{$configFileName}.php"), $configFileName);
        }

        $this->packageRegistered();

        return $this;
    }

    public function newPackage(): PackageOverride
    {
        return new PackageOverride();
    }

    public static function generateMigrationName(string $migrationFileName, Carbon $now): string
    {
        $migrationsPath = 'migrations/';

        $len = strlen($migrationFileName) + 4;

        if (Str::contains($migrationFileName, '/')) {
            $migrationsPath .= Str::of($migrationFileName)->beforeLast('/')->finish('/');
            $migrationFileName = Str::of($migrationFileName)->afterLast('/');
        }

        foreach (glob(database_path("{$migrationsPath}*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName.'.php')) {
                return $filename;
            }
        }

        return database_path($migrationsPath.$now->format('Y_m_d_His').'_'.Str::of($migrationFileName)->snake()->finish('.php'));
    }

    public function registeringPackage() {}

    public function packageRegistered() {}

    public function bootingPackage() {}

    public function packageBooted() {}

    protected function getPackageBaseDir(): string
    {
        $reflector = new ReflectionClass(get_class($this));

        return dirname($reflector->getFileName());
    }

    public function packageView(?string $namespace)
    {
        return is_null($namespace) ? $this->package->shortName() : $this->package->viewNamespace;
    }
}
