<?php
declare (strict_types = 1);

/**
 * This file is part of the BEAR\ReactJsModule package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\SsrModule;

use BEAR\Resource\ResourceObject;
use BEAR\SsrModule\Annotation\Ssr;
use BEAR\SsrModule\Exception\NoAppValueException;
use Koriym\Baracoa\BaracoaInterface;
use Koriym\Baracoa\Exception\JsFileNotExistsException;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

final class SsrInterceptor implements MethodInterceptor
{
    /**
     * @var BaracoaInterface
     */
    private $baracoa;

    public function __construct(BaracoaInterface $baracoa)
    {
        $this->baracoa = $baracoa;
    }

    /**
     * @inheritdoc
     */
    public function invoke(MethodInvocation $invocation)
    {
        $ssr = $invocation->getMethod()->getAnnotation(Ssr::class);
        /* @var $ssr Ssr */
        $app = $ssr->app;
        if (is_null($app)) {
            throw new NoAppValueException();
        }
        $state = array_values($ssr->state);
        $metas = array_values($ssr->metas);
        $renderer = new SeverSideRenderer($this->baracoa, $app, $state, $metas);
        $ro = $invocation->getThis();
        /* @var $ro ResourceObject */
        $ro->setRenderer($renderer);

        return $invocation->proceed();
    }
}
