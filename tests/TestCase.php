<?php

namespace IsmaelilloDev\FilamentScraperPlugin\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use IsmaelilloDev\FilamentScraperPlugin\FilamentScraperPluginServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'IsmaelilloDev\\FilamentScraperPlugin\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            FilamentScraperPluginServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_filament-scraper-plugin_table.php.stub';
        $migration->up();
        */
    }
}
