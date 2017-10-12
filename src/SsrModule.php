<?php

declare(strict_types=1);
/**
 * This file is part of the BEAR.SsrModule package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\SsrModule;

use BEAR\SsrModule\Annotation\Ssr;
use Koriym\Baracoa\Baracoa;
use Koriym\Baracoa\BaracoaInterface;
use Koriym\Baracoa\ExceptionHandler;
use Koriym\Baracoa\ExceptionHandlerInterface;
use Ray\Di\AbstractModule;

class SsrModule extends AbstractModule
{
    /**
     * @var string
     */
    private $bundleSrcBasePath;

    /**
     * @param string              $bundleSrcBasePath js application directory
     * @param AbstractModule|null $module            Module
     */
    public function __construct(string $bundleSrcBasePath, AbstractModule $module = null)
    {
        $this->bundleSrcBasePath = $bundleSrcBasePath;
        parent::__construct($module);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind(SsrFactoryInterface::class)->to(SsrFactory::class);
        $this->bind(BaracoaInterface::class)->toConstructor(Baracoa::class, 'bundleSrcBasePath=bundleSrcBasePath');
        $this->bind()->annotatedWith('bundleSrcBasePath')->toInstance($this->bundleSrcBasePath);
        $this->bind(ExceptionHandlerInterface::class)->to(ExceptionHandler::class);
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith(Ssr::class),
            [SsrInterceptor::class]
        );
        $this->bind(\V8Js::class)->toConstructor(\V8Js::class, 'object_name=v8js_object_name,variables=v8js_variables,extensions=v8js_extensions,report_uncaught_exceptions=v8_report_uncaught_exceptions,snapshot_blob=v8js_snapshot_blob');
        $this->bind()->annotatedWith('v8js_object_name')->toInstance('');
        $this->bind()->annotatedWith('v8js_variables')->toInstance([]);
        $this->bind()->annotatedWith('v8js_extensions')->toInstance([]);
        $this->bind()->annotatedWith('v8_report_uncaught_exceptions')->toInstance(true);
        $this->bind()->annotatedWith('v8js_snapshot_blob')->toInstance('');
    }
}
