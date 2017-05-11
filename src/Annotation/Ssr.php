<?php

declare(strict_types=1);
/**
 * This file is part of the BEAR.SsrModule package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\SsrModule\Annotation;

use Ray\Di\Di\Qualifier;

/**
 * @Annotation
 * @Target("METHOD")
 * @Qualifier
 */
final class Ssr
{
    /**
     * @var string
     */
    public $app;

    /**
     * @var array
     */
    public $state = ['*'];

    /**
     * @var array
     */
    public $metas = [];
}
