<?php

namespace IsmaelilloDev\FilamentScraperPlugin\Actions;

use Illuminate\Database\Eloquent\Model;
use IsmaelilloDev\FilamentScraperPlugin\Models\WebScraper;
use IsmaelilloDev\FilamentScraperPlugin\Spiders\WebSpider;
use Lorisleiva\Actions\Concerns\AsAction;
use RoachPHP\Roach;
use RoachPHP\Spider\Configuration\Overrides;

class RunScraper
{
    use AsAction;

    public string $commandSignature = 'run:scraper';

    public function handle(WebScraper $web)
    {
        Roach::startSpider(
            WebSpider::class,
            new Overrides(
                startUrls: [$web->link]
            ),
            context: ['web' => $web],
        );
    }
}
