<?php

namespace BEAR\SsrModule;

use PHPUnit\Framework\TestCase;
use Ray\Di\Injector;

class SsrModuleTest extends TestCase
{
    /**
     * @var FakeRo
     */
    private $ro;

    protected function setUp()
    {
        $module = new SsrModule(__DIR__ . '/Fake/build');
        $this->ro = (new Injector($module))->getInstance(FakeRo::class);
    }

    public function testInvoke()
    {
        $this->ro->onGet();
        $html = $this->ro->toString();
        $this->assertSame('Hello World', $html);
    }

    /**
     * @expectedException \Koriym\Baracoa\Exception\JsFileNotExistsException
     */
    public function testInvalidAppName()
    {
        $this->ro->onInvalidApp();
        $this->ro->toString();
    }

    /**
     * @expectedException \BEAR\SsrModule\Exception\NoAppValueException
     */
    public function testNoAppName()
    {
        $this->ro->onNoApp();
        $this->ro->toString();
    }

    /**
     * @expectedException \BEAR\SsrModule\Exception\StatusKeyNotExistsException
     */
    public function testNoStatusException()
    {
        $this->ro->onGet();
        $this->ro->body = ['title' => 'exsits'];
        $this->ro->toString();
    }

    /**
     * @expectedException \BEAR\SsrModule\Exception\MetaKeyNotExistsException
     */
    public function testMetaStatusNotExistsException()
    {
        $this->ro->onGet();
        $this->ro->body = ['name' => 'exsits'];
        $this->ro->toString();
    }
}
