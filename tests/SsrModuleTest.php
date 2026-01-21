<?php

declare(strict_types=1);

namespace BEAR\SsrModule;

use BEAR\SsrModule\Exception\MetaKeyNotExistsException;
use BEAR\SsrModule\Exception\NoAppValueException;
use BEAR\SsrModule\Exception\StatusKeyNotExistsException;
use Koriym\Baracoa\Exception\JsFileNotExistsException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Ray\Di\Injector;

#[Group('v8js')]
class SsrModuleTest extends TestCase
{
    private FakeRo $ro;

    protected function setUp(): void
    {
        $module = new SsrModule(__DIR__ . '/Fake/build');
        $this->ro = (new Injector($module))->getInstance(FakeRo::class);
    }

    public function testInvoke(): void
    {
        $this->ro->onGet();
        $html = $this->ro->toString();
        $this->assertSame('Hello World', $html);
    }

    public function testInvalidAppName(): void
    {
        $this->expectException(JsFileNotExistsException::class);
        $this->ro->onInvalidApp();
        $this->ro->toString();
    }

    public function testNoAppName(): void
    {
        $this->expectException(NoAppValueException::class);
        $this->ro->onNoApp();
        $this->ro->toString();
    }

    public function testNoStatusException(): void
    {
        $this->expectException(StatusKeyNotExistsException::class);
        $this->ro->onGet();
        $this->ro->body = ['title' => 'exsits'];
        $this->ro->toString();
    }

    public function testMetaStatusNotExistsException(): void
    {
        $this->expectException(MetaKeyNotExistsException::class);
        $this->ro->onGet();
        $this->ro->body = ['name' => 'exsits'];
        $this->ro->toString();
    }
}
