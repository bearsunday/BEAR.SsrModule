<?php
declare(strict_types=1);

/**
 * This file is part of the BEAR\ReactJsModule package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\SsrModule;

use BEAR\Resource\ResourceObject;
use BEAR\SsrModule\Annotation\Ssr;
use BEAR\SsrModule\Exception\NoAppValue;
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
        $annotation = $invocation->getMethod()->getAnnotation(Ssr::class);
        /* @var $annotation Ssr */
        $app = $annotation->app;
        if (is_null($app)) {
            throw new NoAppValue();
        }
        $renderer = new SeverSideRenderer($this->baracoa, $app);
        $ro = $invocation->getThis();
        /* @var $ro ResourceObject */
        $ro->setRenderer($renderer);

        return $invocation->proceed();
    }
}
