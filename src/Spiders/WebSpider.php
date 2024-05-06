<?php

namespace IsmaelilloDev\FilamentScraperPlugin\Spiders;

use Generator;
use IsmaelilloDev\FilamentScraperPlugin\Models\WebScraper;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use Symfony\Component\DomCrawler\Crawler;

class WebSpider extends BasicSpider
{
    public array $startUrls = [];

    public function parse(Response $response): Generator
    {
        $web = $this->context['web'];
        $selectors = collect($web->selectors[0])->filter(fn ($selector) => $selector !== null);
        $models = $response->filter($selectors['model_selector']);

        if ($web->get_detail && isset($selectors['detail_link_selector'])) {

            $links = $response->filter($selectors['detail_link_selector'])->links();
            foreach ($links as $link) {
                yield $this->request('GET', $link->getUri(), 'parseDetail');
            }

            return;
        }

        unset($selectors['model_selector']);
        $insertData = $this->handleScrape($web, $models, $selectors);

        yield $this->item([
            'data' => $insertData,
        ]);
    }

    public function parseDetail(Response $response): Generator
    {
        $web = $this->context['web'];
        $selectors = collect($web->selectors[0])->filter(fn ($selector) => $selector !== null);
        unset($selectors['model_selector']);
        unset($selectors['detail_link_selector']);

        $data = [];
        foreach ($selectors as $key => $selector) {
            $data[$key] = trim($response->filter($selector)->getNode(0)?->textContent).'';
        }

        $originUrlField = $web->model::originUrlField();
        if ($originUrlField) {
            $data[$originUrlField] = $response->getRequest()->getUri();
        }
        $web->model::upsert([$data], $web->model::uniqueScrapableFields(), $this->getNonUniqueFields($web->model::uniqueScrapableFields(), $web->model::scrapableFields()));
        yield $this->item([
            'data' => $data,
        ]);
    }

    private function handleScrape(WebScraper $web, $models, $selectors)
    {
        $insertData = [];
        $originUrlField = $web->model::originUrlField();

        foreach ($models as $model) {
            $crawler = new Crawler($model, $web->link);
            $data = [];
            foreach ($selectors as $key => $selector) {
                $data[$key] = trim($crawler->filter($selector)->getNode(0)?->textContent);
                if ($originUrlField) {
                    $data[$originUrlField] = $web->link;
                }
            }
            $insertData[] = $data;
        }
        $web->model::upsert($insertData, $web->model::uniqueScrapableFields(), $this->getNonUniqueFields($web->model::uniqueScrapableFields(), $web->model::scrapableFields()));

        return $insertData;
    }

    private function getNonUniqueFields(array $uniqueFields, array $fields)
    {
        return array_values(array_diff($fields, $uniqueFields));
    }
}
