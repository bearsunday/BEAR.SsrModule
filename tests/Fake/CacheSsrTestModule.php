<?php

declare(strict_types=1);

namespace BEAR\SsrModule;

use BEAR\SsrModule\Annotation\SsrCacheConfig;
use Psr\Cache\CacheItemPoolInterface;
use Psr\SimpleCache\CacheInterface;
use Ray\Di\AbstractModule;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;

class CacheSsrTestModule extends AbstractModule
{
    protected function configure(): void
    {
        $this->bind(CacheItemPoolInterface::class)->annotatedWith('array_cache_pool')->to(ArrayAdapter::class);
        $this->bind(CacheInterface::class)->annotatedWith(SsrCacheConfig::class)->toConstructor(
            Psr16Cache::class,
            'pool=array_cache_pool',
        );
        $this->install(new CacheSsrModule());
        $this->install(new SsrModule(__DIR__ . '/build'));
    }
}
