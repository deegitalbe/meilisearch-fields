<?php
namespace Deegitalbe\MeiliSearchIndexes\Contracts;

use Henrotaym\LaravelContainerAutoRegister\Services\AutoRegister\Contracts\AutoRegistrableContract;
use Henrotaym\LaravelPackageVersioning\Services\Versioning\Contracts\VersionablePackageContract;

/**
 * Versioning package.
 */
interface PackageContract extends VersionablePackageContract, AutoRegistrableContract
{
    /**
     * Getting meilisearch indexes matching professional authorization key.
     * 
     * @param string $authorization_key Professional authorization key
     * @return array
     */
    public function indexes(string $authorization_key): array;
}