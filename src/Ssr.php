<?php

declare(strict_types=1);

namespace BEAR\SsrModule;

use BEAR\Resource\RenderInterface;
use BEAR\Resource\ResourceObject;
use BEAR\SsrModule\Exception\MetaKeyNotExistsException;
use BEAR\SsrModule\Exception\StatusKeyNotExistsException;
use Koriym\Baracoa\BaracoaInterface;
use LogicException;

final class Ssr implements RenderInterface
{
    /**
     * @param BaracoaInterface $baracoa   Baracoa instance
     * @param string           $appName   App name
     * @param array<string>    $stateKeys State keys in body
     * @param array<string>    $metaKeys  Meta keys in body
     */
    public function __construct(
        private readonly BaracoaInterface $baracoa,
        private readonly string $appName,
        private readonly array $stateKeys = [],
        private readonly array $metaKeys = [],
    ) {
    }

    public function render(ResourceObject $ro): string
    {
        /** @var array<string, mixed> $body */
        $body = (array) $ro->body;
        $state = $this->filter($this->stateKeys, $body, StatusKeyNotExistsException::class);
        $metas = $this->filter($this->metaKeys, $body, MetaKeyNotExistsException::class);
        $html = $this->baracoa->render($this->appName, $state, $metas);
        $ro->view = $html;

        return $html;
    }

    /**
     * @param array<string>                $keys      Keys to filter
     * @param array<string, mixed>         $body      Body array
     * @param class-string<LogicException> $exception Exception class
     *
     * @return array<string, mixed>
     *
     * @throws LogicException
     */
    private function filter(array $keys, array $body, string $exception): array
    {
        if ($keys === ['*']) {
            return $body;
        }

        $errorKeys = array_diff(array_values($keys), array_keys($body));
        if ($errorKeys !== []) {
            throw new $exception(implode(',', $errorKeys));
        }

        return array_filter($body, static fn(string $key): bool => in_array($key, $keys, true), ARRAY_FILTER_USE_KEY);
    }
}
