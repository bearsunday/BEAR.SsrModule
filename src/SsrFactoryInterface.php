<?php

declare(strict_types=1);

namespace BEAR\SsrModule;

use BEAR\Resource\RenderInterface;

interface SsrFactoryInterface
{
    /**
     * @param string        $appName   UI application name
     * @param array<string> $stateKeys State keys in body
     * @param array<string> $metasKeys Meta keys in body
     */
    public function newInstance(string $appName, array $stateKeys = [], array $metasKeys = []): RenderInterface;
}
