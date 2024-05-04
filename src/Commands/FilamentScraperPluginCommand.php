<?php

namespace IsmaelilloDev\FilamentScraperPlugin\Commands;

use Illuminate\Console\Command;

class FilamentScraperPluginCommand extends Command
{
    public $signature = 'filament-scraper-plugin';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
