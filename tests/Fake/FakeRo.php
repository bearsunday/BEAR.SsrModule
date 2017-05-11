<?php

namespace BEAR\SsrModule;

use BEAR\Resource\ResourceObject;
use BEAR\SsrModule\Annotation\Ssr;

class FakeRo extends ResourceObject
{
    /**
     * @Ssr(app="test_ssr", state={"name"}, metas={"title"})
     */
    public function onGet()
    {
        $this->body = [
            'name' => 'World',
            'title' => 'Title'
        ];

        return $this;
    }

    /**
     * @Ssr(app="__INVALID__")
     */
    public function onInvalidApp()
    {
        return $this;
    }

    /**
     * @Ssr
     */
    public function onNoApp()
    {
        return $this;
    }
}
