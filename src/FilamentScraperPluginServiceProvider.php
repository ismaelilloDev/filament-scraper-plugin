<?php

namespace IsmaelilloDev\FilamentScraperPlugin;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use IsmaelilloDev\FilamentScraperPlugin\Commands\FilamentScraperPluginCommand;

class FilamentScraperPluginServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-scraper-plugin')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('2024_05_04_095627_create_web_scrapers_table');
            // ->hasCommand(FilamentScraperPluginCommand::class);
    }
}
