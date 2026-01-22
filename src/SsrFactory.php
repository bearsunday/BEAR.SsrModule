<?php

declare(strict_types=1);

namespace BEAR\SsrModule;

use BEAR\Resource\RenderInterface;
use Koriym\Baracoa\BaracoaInterface;

final class SsrFactory implements SsrFactoryInterface
{
    public function __construct(
        private readonly BaracoaInterface $baracoa,
    ) {
    }

    /**
     * @param string        $appName   UI application name
     * @param array<string> $stateKeys State keys in body
     * @param array<string> $metasKeys Meta keys in body
     */
    public function newInstance(string $appName, array $stateKeys = [], array $metasKeys = []): RenderInterface
    {
        return new Ssr($this->baracoa, $appName, $stateKeys, $metasKeys);
    }
}
