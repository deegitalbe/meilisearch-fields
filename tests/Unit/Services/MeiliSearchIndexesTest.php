<?php
namespace Deegitalbe\MeiliSearchIndexes\Tests\Unit\Services;

use Mockery\MockInterface;
use Illuminate\Support\Collection;
use Deegitalbe\MeiliSearchIndexes\Tests\TestCase;
use Deegitalbe\MeiliSearchIndexes\Services\MeiliSearchIndexes;

class MeiliSearchIndexesTest extends TestCase
{
    /** @test */
    public function meilisearch_indexes_service_setting_authorization_key()
    {
        $this->setService();

        $response = $this->callPrivateMethod('setAuthorizationKey', $this->service, $this->authorization_key);
        $this->assertEquals(
            $this->authorization_key,
            $this->getPrivateProperty("authorization_key", $this->service)
        );

        $this->assertInstanceOf(MeiliSearchIndexes::class, $response);
    }

    /** @test */
    public function meilisearch_indexes_service_setting_app_key()
    {
        $this->setService();

        $response = $this->callPrivateMethod('setAppKey', $this->service, $this->app_key);
        $this->assertEquals(
            $this->app_key,
            $this->getPrivateProperty("app_key", $this->service)
        );

        $this->assertInstanceOf(MeiliSearchIndexes::class, $response);
    }

    /** @test */
    public function meilisearch_indexes_service_getting_app_key()
    {
        $this->setService();

        $this->assertNull($this->callPrivateMethod('getAppKey', $this->service));
    }

    /** @test */
    public function meilisearch_indexes_service_getting_authorization_key()
    {
        $this->setService();

        $this->assertNull($this->callPrivateMethod('getAuthorizationKey', $this->service));
    }

    /** @test */
    public function meilisearch_indexes_service_getting_indexes_by_app()
    {
        $this->setService();

        /** @var Collection */
        $response = $this->callPrivateMethod('getIndexesByApp', $this->service);

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals($this->getIndexes(), $response->all());
    }

    /** @test */
    public function meilisearch_indexes_service_prefixing_index()
    {
        $this->mockService();

        $this->service_mock->expects()->getAppKey()->andReturn($this->app_key);
        $this->service_mock->expects()->getAuthorizationKey()->andReturn($this->authorization_key);
        $this->service_mock->expects()->prefixIndex($this->index)->passthru();

        $this->assertEquals("{$this->authorization_key}_{$this->app_key}_{$this->index}", $this->service_mock->prefixIndex($this->index));
    }

    /** @test */
    public function meilisearch_indexes_service_prefixing_indexes()
    {
        $this->mockService();
        $app_indexes = $this->getIndexes()[$this->app_key];

        $this->service_mock->expects()->setAppKey($this->app_key)->andReturnSelf();
        $this->service_mock->expects()->prefixIndex()->withArgs(function(string $index) use ($app_indexes) { return in_array($index, $app_indexes); })->andReturn(true);
        $this->service_mock->expects()->prefixIndexes($app_indexes, $this->app_key)->passthru();

        $this->assertEquals([true] , $this->service_mock->prefixIndexes($app_indexes, $this->app_key));
    }

    /** @test */
    public function meilisearch_indexes_service_getting_prefixed_indexes()
    {
        $this->mockService();

        $this->service_mock->expects()->setAuthorizationKey($this->authorization_key)->andReturnSelf();
        $this->service_mock->expects()->getIndexesByApp()->andReturn(collect($this->getIndexes()));
        $this->service_mock->expects()->prefixIndexes()->withArgs(function(array $indexes, string $app_key) {
            return $app_key === $this->app_key && $indexes === $this->getIndexes()[$this->app_key];
        })->andReturn($this->getIndexes()[$this->app_key]);
        $this->service_mock->expects()->get($this->authorization_key)->passthru();

        $this->assertEquals($this->getIndexes() , $this->service_mock->get($this->authorization_key));
    }

    protected $authorization_key = ":auth_key";

    protected $app_key = ":app_key";

    protected $index = ":table_name";

    protected function getIndexes(): array
    {
        return [$this->app_key => [$this->index]];
    }

    /** @var MeiliSearchIndexes */
    protected $service;

    protected function setService(): self
    {
        $this->service = app()->make(MeiliSearchIndexes::class);
        $this->setPrivateProperty('indexes_by_app', $this->getIndexes(), $this->service);

        return $this;
    }

    /** @var MeiliSearchIndexes|MockInterface */
    protected $service_mock;
    
    protected function mockService(): self
    {
        $this->service_mock = $this->mockThis(MeiliSearchIndexes::class);

        return $this;
    }
}