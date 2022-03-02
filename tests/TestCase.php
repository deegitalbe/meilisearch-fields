<?php
namespace Deegitalbe\MeiliSearchIndexes\Tests;

use Deegitalbe\MeiliSearchIndexes\Package;
use Henrotaym\LaravelPackageVersioning\Testing\VersionablePackageTestCase;
use Deegitalbe\MeiliSearchIndexes\Providers\MeilisearchIndexesServiceProvider;

class TestCase extends VersionablePackageTestCase
{
    public static function getPackageClass(): string
    {
        return Package::class;
    }
    
    public function getServiceProviders(): array
    {
        return [
            MeilisearchIndexesServiceProvider::class
        ];
    }
}