<?php

namespace MarsworksInc\LaravelInsightly\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use MarsworksInc\LaravelInsightly\LaravelInsightlyServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'MarsworksInc\\LaravelInsightly\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelInsightlyServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        include_once __DIR__.'/../database/migrations/create_laravel-insightly_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}
