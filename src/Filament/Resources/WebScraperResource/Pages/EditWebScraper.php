<?php

namespace IsmaelilloDev\FilamentScraperPlugin\Filament\Resources\WebScraperResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use IsmaelilloDev\FilamentScraperPlugin\Filament\Resources\WebScraperResource;

class EditWebScraper extends EditRecord
{
    protected static string $resource = WebScraperResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
