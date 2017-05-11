<?php

declare(strict_types=1);
/**
 * This file is part of the BEAR.SsrModule package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\SsrModule;

use BEAR\Resource\ResourceObject;
use BEAR\SsrModule\Annotation\Ssr;
use BEAR\SsrModule\Exception\NoAppValueException;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

final class SsrInterceptor implements MethodInterceptor
{
    /**
     * Server side renderer factory
     *
     * @var SsrFactoryInterface
     */
    private $factory;

    public function __construct(SsrFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Set server side render with @Ssr annotation meta data
     *
     * {@inheritdoc}
     */
    public function invoke(MethodInvocation $invocation)
    {
        $ssr = $invocation->getMethod()->getAnnotation(Ssr::class);
        /* @var $ssr Ssr */
        $app = $ssr->app;
        if ($app === null) {
            throw new NoAppValueException();
        }
        $state = array_values($ssr->state);
        $metas = array_values($ssr->metas);
        $renderer = $this->factory->newInstance($app, $state, $metas);
        $ro = $invocation->getThis();
        /* @var $ro ResourceObject */
        $ro->setRenderer($renderer);

        return $invocation->proceed();
    }
}
