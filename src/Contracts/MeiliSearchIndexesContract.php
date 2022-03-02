<?php
namespace Deegitalbe\MeiliSearchIndexes\Services;

use Illuminate\Support\Collection;
/** Meilisearch indexes. */
interface MeiliSearchIndexesContract
{
    /**
     * Getting available indexes matching given authorization_key.
     * 
     * @param string $authorization_key Professional authorization key.
     * @return array
     */
    public function get(string $authorization_key): array;
}