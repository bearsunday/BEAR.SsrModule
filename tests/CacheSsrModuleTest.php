<?php

declare(strict_types=1);

namespace BEAR\SsrModule;

use Koriym\Baracoa\BaracoaInterface;
use Koriym\Baracoa\CacheBaracoa;
use PHPUnit\Framework\TestCase;
use Ray\Di\Injector;

class CacheSsrModuleTest extends TestCase
{
    public function testGetInstance(): void
    {
        $module = new CacheSsrTestModule();
        $baracoa = (new Injector($module))->getInstance(BaracoaInterface::class);
        $this->assertInstanceOf(CacheBaracoa::class, $baracoa);
    }
}
