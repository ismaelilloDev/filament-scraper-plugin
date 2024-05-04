<?php

namespace IsmaelilloDev\FilamentScraperPlugin\Actions;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Lorisleiva\Actions\Concerns\AsAction;

class GenerateDynamicFormForTheSelectors
{
    use AsAction;

    public string $commandSignature = 'generate:form';

    public function handle(): array
    {
        $schema = [];
        $db_models = GetAllDataBaseModels::run();
        foreach ($db_models as $key => $model) {
            $columns = GetModelColumns::run(new $key);
            $repeater_schema[] = TextInput::make('model_selector')->required();
            foreach ($columns as $column) {
                $repeater_schema[] = TextInput::make(''.$column)->required();
            }
            $schema[] = Repeater::make('selectors')
                ->schema($repeater_schema)
                ->columnSpanFull()
                ->maxItems(1)
                ->visible(fn (Get $get) => $get('model') === $key);
        }

        return $schema;
    }
}
