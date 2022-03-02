<?php
namespace Deegitalbe\MeiliSearchIndexes;

use Deegitalbe\MeiliSearchIndexes\Contracts\PackageContract;
use Deegitalbe\MeiliSearchIndexes\Services\MeiliSearchIndexesContract;
use Henrotaym\LaravelContainerAutoRegister\Services\AutoRegister\Contracts\AutoRegistrableContract;
use Henrotaym\LaravelPackageVersioning\Services\Versioning\VersionablePackage;

class Package extends VersionablePackage implements PackageContract
{
    public static function prefix(): string
    {
        return "meilisearch_fields";
    }

    /**
     * Getting meilisearch indexes matching professional authorization key.
     * 
     * @param string $authorization_key Professional authorization key
     * @return array
     */
    public function indexes(string $authorization_key): array
    {
        /** @var MeiliSearchIndexesContract */
        $indexes = app()->make(MeiliSearchIndexesContract::class);
        
        return $indexes->get($authorization_key);
    }
}