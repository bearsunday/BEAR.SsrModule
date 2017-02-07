<?php

namespace BEAR\SsrModule;

use BEAR\SsrModule\Annotation\SsrCacheConfig;
use Psr\SimpleCache\CacheInterface;
use Ray\Di\AbstractModule;
use Symfony\Component\Cache\Simple\ArrayCache;

class CacheSsrTestModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->install(new CacheSsrModule());
        $this->bind(CacheInterface::class)->annotatedWith(SsrCacheConfig::class)->to(ArrayCache::class);
        $this->install(new SsrModule(__DIR__ . '/Fake/build'));
    }
}
