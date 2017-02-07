<?php
declare (strict_types = 1);

/**
 * This file is part of the BEAR\ReactJsModule package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\SsrModule;

use BEAR\SsrModule\Annotation\SsrCacheConfig;
use Koriym\Baracoa\BaracoaInterface;
use Koriym\Baracoa\CacheBaracoa;
use Ray\Di\AbstractModule;

class CacheSsrModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind(BaracoaInterface::class)->toConstructor(CacheBaracoa::class, 'bundleSrcBasePath=bundleSrcBasePath,cache=' . SsrCacheConfig::class);
    }
}
