<?php

declare(strict_types=1);

namespace BEAR\SsrModule;

use BEAR\Resource\ResourceObject;
use BEAR\SsrModule\Annotation\Ssr;
use BEAR\SsrModule\Exception\NoAppValueException;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

final class SsrInterceptor implements MethodInterceptor
{
    public function __construct(
        private readonly SsrFactoryInterface $factory,
    ) {
    }

    public function invoke(MethodInvocation $invocation): ResourceObject
    {
        /** @var Ssr $ssr */
        $ssr = $invocation->getMethod()->getAnnotation(Ssr::class);
        $app = $ssr->app;
        if ($app === null) {
            throw new NoAppValueException();
        }

        $state = array_values($ssr->state);
        $metas = array_values($ssr->metas);
        $renderer = $this->factory->newInstance($app, $state, $metas);
        /** @var ResourceObject $ro */
        $ro = $invocation->getThis();
        $ro->setRenderer($renderer);

        /** @var ResourceObject */
        return $invocation->proceed();
    }
}
