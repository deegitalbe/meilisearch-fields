<?php
namespace Deegitalbe\MeiliSearchIndexes\Services;

use Deegitalbe\MeiliSearchIndexes\Contracts\MeiliSearchIndexesContract;
use Illuminate\Support\Collection;
/** Meilisearch indexes. */
class MeiliSearchIndexes implements MeiliSearchIndexesContract
{
    /**
     * Available indexes keyed by their respective app_key.
     * 
     * @return array
     */
    protected $indexes_by_app = [
        "contact" => ["contacts", "test", "tuttu"], 
        "invoicing" => ["invoices"]
    ];

    /**
     * Related app key.
     * 
     * @var string|null
     */
    protected $app_key;

    /**
     * Related professional authorization key.
     * 
     *  @return string|null
     */
    protected $authorization_key;
    
    /**
     * Getting available indexes matching given authorization_key.
     * 
     * @param string $authorization_key Professional authorization key.
     * @return array
     */
    public function get(string $authorization_key): array
    {
        $this->setAuthorizationKey($authorization_key);

        return $this->getIndexesByApp()
            ->map([$this, 'prefixIndexes'])
            ->all();
    }

    /**
     * Getting available indexes keyed by their respective app_key.
     * 
     * @return Collection
     */
    protected function getIndexesByApp(): Collection
    {
        return collect($this->indexes_by_app);
    }

    /**
     * Getting related app key.
     * 
     * @return string
     */
    protected function getAppKey(): ?string
    {
        return $this->app_key;
    }

    /**
     * Getting related professional authorization key.
     * 
     * @return string
     */
    protected function getAuthorizationKey(): ?string
    {
        return $this->authorization_key;
    }

    /**
     * Prefixing given indexes belonging to given app.
     * 
     * @param array $indexes App indexes.
     * @return array
     */
    public function prefixIndexes(array $indexes, string $app): array
    {
        $this->setAppKey($app);

        return collect($indexes)->mapWithKeys([$this, 'prefixIndex'])->all();
    }

    /**
     * Prefixing given index.
     * 
     * @param string $index Index to prefix.
     * @return string[]
     */
    public function prefixIndex(string $index): array
    {
        return [$index => join("_", [$this->getAuthorizationKey(), $this->getAppKey(), $index])];
    }

    /**
     * Setting related professional authorization key.
     * 
     * @return static
     */
    protected function setAuthorizationKey(string $authorization_key): MeiliSearchIndexes
    {
        $this->authorization_key = $authorization_key;

        return $this;
    }

    /**
     * Setting related app key.
     * 
     * @param string $app App key.
     * @return static
     */
    protected function setAppKey(string $app): MeiliSearchIndexes
    {
        $this->app_key = $app;
        
        return $this;
    }
}