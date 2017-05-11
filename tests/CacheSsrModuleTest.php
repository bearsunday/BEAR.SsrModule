<?php
/**
 * This file is part of the BEAR.SsrModule package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\SsrModule;

use Koriym\Baracoa\BaracoaInterface;
use Koriym\Baracoa\CacheBaracoa;
use PHPUnit\Framework\TestCase;
use Ray\Di\Injector;

class CacheSsrModuleTest extends TestCase
{
    public function testGetInstance()
    {
        $module = new CacheSsrTestModule;
        $baracoa = (new Injector($module))->getInstance(BaracoaInterface::class);
        $this->assertInstanceOf(CacheBaracoa::class, $baracoa);
    }
}
