<?php

declare(strict_types=1);
/**
 * This file is part of the BEAR.SsrModule package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\SsrModule;

use Koriym\Baracoa\BaracoaInterface;

final class SsrFactory implements SsrFactoryInterface
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
     * [@inheritdoc}
     */
    public function newInstance(string $appName, array $stateKeys = [], array $metasKeys = [])
    {
        return new Ssr($this->baracoa, $appName, $stateKeys, $metasKeys);
    }
}
