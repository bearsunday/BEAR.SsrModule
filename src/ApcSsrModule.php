<?php

declare(strict_types=1);

namespace BEAR\SsrModule;

use BEAR\SsrModule\Annotation\SsrCacheConfig;
use Psr\Cache\CacheItemPoolInterface;
use Psr\SimpleCache\CacheInterface;
use Ray\Di\AbstractModule;
use Symfony\Component\Cache\Adapter\ApcuAdapter;
use Symfony\Component\Cache\Psr16Cache;

class ApcSsrModule extends AbstractModule
{
    protected function configure(): void
    {
        $this->bind(CacheItemPoolInterface::class)->annotatedWith('ssr_cache_pool')->to(ApcuAdapter::class);
        $this->bind(CacheInterface::class)->annotatedWith(SsrCacheConfig::class)->toConstructor(
            Psr16Cache::class,
            'pool=ssr_cache_pool',
        );
        $this->install(new CacheSsrModule());
        $this->install(new SsrModule(__DIR__ . '/Fake/build'));
    }
}
