<?php

namespace Marsworksinc\LaravelInsightly;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelInsightlyServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-insightly')
            ->hasConfigFile();
    }

    public function registeringPackage()
    {
        $this->app->singleton('insightly', function () {
            return new LaravelInsightly(
                config('insightly.url'),
                config('insightly.key'),
                config('insightly.version'),
            );
        });
    }
}
