<?php

namespace IsmaelilloDev\FilamentScraperPlugin\Spiders;

use Generator;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;
use Symfony\Component\DomCrawler\Crawler;

class WebSpider extends BasicSpider
{
    public array $startUrls = [];

    public function parse(Response $response): Generator
    {
        $web = $this->context['web'];
        $selectors = collect($web->selectors[0])->filter(fn ($selector) => $selector !== null );
        $models = $response->filter($selectors['model_selector']);
        unset($selectors['model_selector']);
        $insertData = [];
        foreach ($models as $model) {
            $crawler = new Crawler($model, $web->link);
            $data = [];
            foreach ($selectors as $key => $selector) {
                $data[$key] = trim($crawler->filter($selector)->getNode(0)?->textContent);
            }
            $insertData[] = $data;
        }
        $web->model::upsert($insertData, ['title'], ['description']);
        yield $this->item([
            'title' => $insertData
        ]);
    }
}
