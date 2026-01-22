<?php

declare(strict_types=1);

namespace BEAR\SsrModule;

use BEAR\SsrModule\Annotation\Ssr;
use Koriym\Baracoa\Baracoa;
use Koriym\Baracoa\BaracoaInterface;
use Koriym\Baracoa\ExceptionHandler;
use Koriym\Baracoa\ExceptionHandlerInterface;
use Ray\Di\AbstractModule;
use V8Js;

class SsrModule extends AbstractModule
{
    public function __construct(
        private readonly string $bundleSrcBasePath,
        ?AbstractModule $module = null,
    ) {
        parent::__construct($module);
    }

    protected function configure(): void
    {
        $this->bind(SsrFactoryInterface::class)->to(SsrFactory::class);
        $this->bind(BaracoaInterface::class)->toConstructor(Baracoa::class, 'bundleSrcBasePath=bundleSrcBasePath');
        $this->bind()->annotatedWith('bundleSrcBasePath')->toInstance($this->bundleSrcBasePath);
        $this->bind(ExceptionHandlerInterface::class)->to(ExceptionHandler::class);
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith(Ssr::class),
            [SsrInterceptor::class],
        );
        $this->bind(V8Js::class)->toConstructor(V8Js::class, 'object_name=v8js_object_name,variables=v8js_variables');
        $this->bind()->annotatedWith('v8js_object_name')->toInstance('');
        $this->bind()->annotatedWith('v8js_variables')->toInstance([]);
    }
}
