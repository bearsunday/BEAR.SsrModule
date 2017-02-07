<?php
declare (strict_types = 1);

/**
 * This file is part of the BEAR\ReactJsModule package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\SsrModule;

use BEAR\Resource\RenderInterface;
use BEAR\Resource\ResourceObject;
use Koriym\Baracoa\BaracoaInterface;

final class SeverSideRenderer implements RenderInterface
{
    /**
     * @var BaracoaInterface
     */
    private $baracoa;

    /**
     * @var string
     */
    private $appName;

    /**
     * @var array
     */
    private $stateKeys;

    /**
     * @var array
     */
    private $metaKeys;

    /**
     * @param BaracoaInterface $baracoa
     */
    public function __construct(BaracoaInterface $baracoa, string $appName, array $stateKeys = [], array $metasKeys = [])
    {
        $this->baracoa = $baracoa;
        $this->appName = $appName;
        $this->stateKeys = $stateKeys;
        $this->metaKeys = $metasKeys;
    }

    public function render(ResourceObject $ro)
    {
        $state = $this->filter($this->stateKeys, (array) $ro->body);
        $metas = $this->filter($this->metaKeys, (array) $ro->body);
        $html = $this->baracoa->render($this->appName, $state, $metas);
        $ro->view = $html;

        return $html;
    }

    private function filter(array $keys, array $body) : array
    {
        if ($keys === ['*']) {
            return $body;
        }
        $errorKeys = array_keys(array_diff(array_values($keys), array_keys($body)));
        if ($errorKeys) {
            throw new \LogicException(implode(',', $errorKeys));
        }
        $filterd = array_filter((array) $body, function ($key) use ($keys) {
            return in_array($key, $keys);
        }, ARRAY_FILTER_USE_KEY);

        return $filterd;
    }
}
