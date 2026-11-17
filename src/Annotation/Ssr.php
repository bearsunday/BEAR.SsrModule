<?php

declare(strict_types=1);

namespace BEAR\SsrModule\Annotation;

use Attribute;
use Ray\Di\Di\Qualifier;

/**
 * Renders the response of the method on the server with the JavaScript application `app`
 *
 * @see https://bearsunday.github.io/manuals/1.0/en/reference.html#attributes
 * @see \BEAR\SsrModule\SsrInterceptor
 */
#[Attribute(Attribute::TARGET_METHOD)]
#[Qualifier]
final class Ssr
{
    /**
     * @param string|null   $app   Name of the JS application bundle; null throws NoAppValueException
     * @param array<string> $state Body keys sent to the client as the application state; `['*']` passes the whole body
     * @param array<string> $metas Body keys passed to the render function on the server only, such as the page title
     */
    public function __construct(
        public readonly ?string $app = null,
        public readonly array $state = ['*'],
        public readonly array $metas = [],
    ) {
    }
}
