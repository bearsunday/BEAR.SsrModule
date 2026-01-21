<?php

declare(strict_types=1);

namespace BEAR\SsrModule;

use BEAR\SsrModule\Annotation\SsrCacheConfig;
use Koriym\Baracoa\BaracoaInterface;
use Koriym\Baracoa\CacheBaracoa;
use Ray\Di\AbstractModule;

class CacheSsrModule extends AbstractModule
{
    protected function configure(): void
    {
        $this->bind(BaracoaInterface::class)->toConstructor(CacheBaracoa::class, 'bundleSrcBasePath=bundleSrcBasePath,cache=' . SsrCacheConfig::class);
    }
}
