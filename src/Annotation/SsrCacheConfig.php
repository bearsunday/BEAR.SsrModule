<?php

declare(strict_types=1);

namespace BEAR\SsrModule\Annotation;

use Attribute;
use Ray\Di\Di\Qualifier;

/** Qualifies the PSR-16 cache that keeps the V8Js snapshot of each SSR application */
#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_PARAMETER)]
#[Qualifier]
final class SsrCacheConfig
{
}
