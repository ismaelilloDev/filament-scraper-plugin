<?php

namespace IsmaelilloDev\FilamentScraperPlugin\Contracts;

interface IsScrapable
{
    public static function scrapableFields(): array;

    public static function uniqueScrapableFields(): array;
}
