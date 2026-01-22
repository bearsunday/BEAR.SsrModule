<?php

declare(strict_types=1);

namespace BEAR\SsrModule;

use Koriym\Baracoa\BaracoaInterface;
use Koriym\Baracoa\CacheBaracoa;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Ray\Di\Injector;

#[Group('v8js')]
class ApcCacheSsrModuleTest extends TestCase
{
    public function testGetInstance(): void
    {
        $module = new ApcSsrModule(__DIR__ . '/Fake/build');
        $baracoa = (new Injector($module))->getInstance(BaracoaInterface::class);
        $this->assertInstanceOf(CacheBaracoa::class, $baracoa);
    }
}
