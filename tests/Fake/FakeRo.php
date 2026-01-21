<?php

declare(strict_types=1);

namespace BEAR\SsrModule;

use BEAR\Resource\ResourceObject;
use BEAR\SsrModule\Annotation\Ssr;

class FakeRo extends ResourceObject
{
    #[Ssr(app: 'test_ssr', state: ['name'], metas: ['title'])]
    public function onGet(): static
    {
        $this->body = [
            'name' => 'World',
            'title' => 'Title',
        ];

        return $this;
    }

    #[Ssr(app: '__INVALID__')]
    public function onInvalidApp(): static
    {
        return $this;
    }

    #[Ssr]
    public function onNoApp(): static
    {
        return $this;
    }
}
