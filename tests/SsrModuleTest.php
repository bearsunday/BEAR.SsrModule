<?php

namespace BEAR\SsrModule;

use Koriym\Baracoa\Baracoa;
use Koriym\Baracoa\BaracoaInterface;
use Ray\Di\Injector;

class SsrModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $module = new SsrModule(__DIR__ . '/Fake/build');
        $baracoa = (new Injector($module))->getInstance(BaracoaInterface::class);
        $this->assertInstanceOf(Baracoa::class, $baracoa);
        $ro = (new Injector($module))->getInstance(FakeRo::class);
        $this->assertInstanceOf(FakeRo::class, $ro);

        return $ro;
    }

    /**
     * @depends testGetInstance
     */
    public function testInvoke(FakeRo $ro)
    {
        $ro->onGet();
        $html = (string) $ro;
        $this->assertSame('Hello World', $html);
    }

    /**
     * @depends testGetInstance
     * @expectedException \Koriym\Baracoa\Exception\JsFileNotExistsException
     */
    public function testInvalidAppName(FakeRo $ro)
    {
        $ro->onInvalidApp();
        $ro->toString();
    }

    /**
     * @depends testGetInstance
     * @expectedException \BEAR\SsrModule\Exception\NoAppValue
     */
    public function testNoAppName(FakeRo $ro)
    {
        $ro->onNoApp();
        $ro->toString();
    }
}
