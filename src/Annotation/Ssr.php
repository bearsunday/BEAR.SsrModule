<?php

declare(strict_types=1);

namespace BEAR\SsrModule\Annotation;

use Attribute;
use Ray\Di\Di\Qualifier;

#[Attribute(Attribute::TARGET_METHOD)]
#[Qualifier]
final class Ssr
{
    /**
     * @param string|null   $app   App name
     * @param array<string> $state State keys in body
     * @param array<string> $metas Meta keys in body
     */
    public function __construct(
        public readonly ?string $app = null,
        public readonly array $state = ['*'],
        public readonly array $metas = [],
    ) {
    }
}
