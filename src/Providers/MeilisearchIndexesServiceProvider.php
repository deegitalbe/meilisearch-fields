<?php
namespace Deegitalbe\MeiliSearchIndexes\Providers;

use Deegitalbe\MeiliSearchIndexes\Package;
use Deegitalbe\MeiliSearchIndexes\Services\MeiliSearchIndexes;
use Deegitalbe\MeiliSearchIndexes\Services\MeiliSearchIndexesContract;
use Henrotaym\LaravelPackageVersioning\Providers\Abstracts\VersionablePackageServiceProvider;

class MeilisearchIndexesServiceProvider extends VersionablePackageServiceProvider
{
    public static function getPackageClass(): string
    {
        return Package::class;
    }

    protected function addToRegister(): void
    {
        $this->app->bind(MeiliSearchIndexesContract::class, MeiliSearchIndexes::class);
    }

    protected function addToBoot(): void
    {
        //
    }
}