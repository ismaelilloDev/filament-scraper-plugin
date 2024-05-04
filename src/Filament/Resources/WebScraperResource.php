<?php

namespace IsmaelilloDev\FilamentScraperPlugin\Filament\Resources;



use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use IsmaelilloDev\FilamentScraperPlugin\Actions\GenerateDynamicFormForTheSelectors;
use IsmaelilloDev\FilamentScraperPlugin\Actions\GetAllDataBaseModels;
use IsmaelilloDev\FilamentScraperPlugin\Actions\RunScraper;
use IsmaelilloDev\FilamentScraperPlugin\Filament\Resources\WebScraperResource\Pages\CreateWebScraper;
use IsmaelilloDev\FilamentScraperPlugin\Filament\Resources\WebScraperResource\Pages\EditWebScraper;
use IsmaelilloDev\FilamentScraperPlugin\Filament\Resources\WebScraperResource\Pages\ListWebScrapers;
use IsmaelilloDev\FilamentScraperPlugin\Models\WebScraper;

class WebScraperResource extends Resource
{
    protected static ?string $model = WebScraper::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    public static function form(Form $form): Form
    {
        $schema = GenerateDynamicFormForTheSelectors::run();
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                        Forms\Components\TextInput::make('link')
                            ->required(),
                        Forms\Components\Select::make('model')
                            ->options(GetAllDataBaseModels::run())
                            ->live()
                            ->reactive()
                            ->required()
                    ]),
                ...$schema
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('model')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('import')
                    ->action(function ($record) {
                        RunScraper::run($record);
                        Notification::make()->title('Data imported successfully')->success()->send();
                    })
                    ->icon('heroicon-o-arrow-down-circle')
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWebScrapers::route('/'),
            'create' => CreateWebScraper::route('/create'),
            'edit' => EditWebScraper::route('/{record}/edit'),
        ];
    }
}
