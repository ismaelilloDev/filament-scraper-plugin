<?php

namespace IsmaelilloDev\FilamentScraperPlugin\Actions;

use Exception;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
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
                /** @phpstan-ignore-next-line */
                $class = sprintf('\%s%s', Container::getInstance()->getNamespace(), strtr(substr($path, 0, strrpos($path, '.')), '/', '\\'));

                return $class;
            })->filter(function ($class) {
                try {
                    $reflection = new \ReflectionClass($class);

                    return $reflection->isSubclassOf(Model::class) && ! $reflection->isAbstract() && $reflection->implementsInterface(IsScrapable::class);
                } catch (Exception $e) {
                    return false;
                }
            });

        $formattedModels = $models->mapWithKeys(function ($model, $key) {
            return [$model => class_basename($model)];
        });

        return $formattedModels;
    }
}
