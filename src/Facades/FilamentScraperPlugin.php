<?php

namespace IsmaelilloDev\FilamentScraperPlugin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \IsmaelilloDev\FilamentScraperPlugin\FilamentScraperPlugin
 */
class FilamentScraperPlugin extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \IsmaelilloDev\FilamentScraperPlugin\FilamentScraperPlugin::class;
    }
}
