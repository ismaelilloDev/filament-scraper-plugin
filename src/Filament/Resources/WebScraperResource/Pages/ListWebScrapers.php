<?php

namespace IsmaelilloDev\FilamentScraperPlugin\Filament\Resources\WebScraperResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use IsmaelilloDev\FilamentScraperPlugin\Filament\Resources\WebScraperResource;

class ListWebScrapers extends ListRecords
{
    protected static string $resource = WebScraperResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
