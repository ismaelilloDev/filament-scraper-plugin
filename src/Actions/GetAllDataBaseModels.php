<?php

namespace IsmaelilloDev\FilamentScraperPlugin\Actions;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use IsmaelilloDev\FilamentScraperPlugin\Contracts\IsScrapable;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAllDataBaseModels
{
    use AsAction;

    public string $commandSignature = 'get:database-models';

    public function handle()
    {
        $models = collect(File::allFiles(app_path()))
            ->map(function ($item) {
                $path = $item->getRelativePathName();
                $class = sprintf('\%s%s', Container::getInstance()->getNamespace(), strtr(substr($path, 0, strrpos($path, '.')), '/', '\\'));
                return $class;
            })->filter(function($class){
                $reflection = new \ReflectionClass($class);
                return $reflection->isSubclassOf(Model::class) && !$reflection->isAbstract() && $reflection->implementsInterface(IsScrapable::class);
            });

        $formattedModels = $models->mapWithKeys(function ($model, $key) {
            return [$model => class_basename($model)];
        });
        return $formattedModels;
    }

    private function formatNameSpace($relativePath)
    {
        // @phpstan-ignore-next-line
        return Str::beforeLast(Container::getInstance()->getNamespace(). $relativePath,'.php');
    }
}
