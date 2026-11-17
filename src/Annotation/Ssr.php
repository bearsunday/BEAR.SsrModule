<?php

declare(strict_types=1);

namespace BEAR\SsrModule\Annotation;

use Attribute;
use Ray\Di\Di\Qualifier;

/**
 * Renders the response of the method on the server with the JavaScript application `app`
 *
 * @see \BEAR\SsrModule\SsrInterceptor
 */
#[Attribute(Attribute::TARGET_METHOD)]
#[Qualifier]
final class Ssr
{
    /**
     * @param string|null   $app   Name of the JS application bundle; null throws NoAppValueException
     * @param array<string> $state Body keys passed as the first argument of the JS `render(state, metas)`; `['*']` passes
     *                             the whole body, and a key not in the body throws StatusKeyNotExistsException
     * @param array<string> $metas Body keys passed as the second argument of the JS `render(state, metas)`; `['*']` passes
     *                             the whole body, and a key not in the body throws MetaKeyNotExistsException
     */
    public function __construct(
        public readonly ?string $app = null,
        public readonly array $state = ['*'],
        public readonly array $metas = [],
    ) {
    }
}
