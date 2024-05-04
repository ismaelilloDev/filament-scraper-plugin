<?php

namespace IsmaelilloDev\FilamentScraperPlugin\Actions;

use Illuminate\Database\Eloquent\Model;
use IsmaelilloDev\FilamentScraperPlugin\Contracts\IsScrapable;
use Lorisleiva\Actions\Concerns\AsAction;

class GetModelColumns
{
    use AsAction;

    public function handle(Model $model): array
    {
        if (! $model instanceof IsScrapable) {
            return [];
        }

        return $model::scrapableFields();
    }
}
