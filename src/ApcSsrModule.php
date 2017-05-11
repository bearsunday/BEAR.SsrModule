<?php

declare(strict_types=1);
/**
 * This file is part of the BEAR.SsrModule package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\SsrModule;

use BEAR\SsrModule\Annotation\SsrCacheConfig;
use Psr\SimpleCache\CacheInterface;
use Ray\Di\AbstractModule;
use Symfony\Component\Cache\Simple\ApcuCache;

class ApcSsrModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        // bind ssr cache
        $this->bind(CacheInterface::class)->annotatedWith(SsrCacheConfig::class)->to(ApcuCache::class);
        // install module
        $this->install(new CacheSsrModule());
        $this->install(new SsrModule(__DIR__ . '/Fake/build'));
    }
}
