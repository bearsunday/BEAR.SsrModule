<?php

declare(strict_types=1);
/**
 * This file is part of the BEAR.SsrModule package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\SsrModule;

use BEAR\Resource\RenderInterface;

interface SsrFactoryInterface
{
    /**
     * @param string $appName   UI application name
     * @param array  $stateKeys state keys in body
     * @param array  $metasKeys meta keys in body
     *
     * @return RenderInterface
     */
    public function newInstance(string $appName, array $stateKeys = [], array $metasKeys = []);
}
