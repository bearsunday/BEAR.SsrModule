<?php

namespace BEAR\SsrModule;

use Koriym\Baracoa\Baracoa;
use Koriym\Baracoa\BaracoaInterface;
use Koriym\Baracoa\CacheBaracoa;
use Ray\Di\Injector;

class CacheSsrModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $module = new CacheSsrTestModule;
        $baracoa = (new Injector($module))->getInstance(BaracoaInterface::class);
        $this->assertInstanceOf(CacheBaracoa::class, $baracoa);
    }
}
