<?php
declare(strict_types=1);

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
     * @param BaracoaInterface $baracoa
     */
    public function __construct(BaracoaInterface $baracoa, string $appName)
    {
        $this->baracoa = $baracoa;
        $this->appName = $appName;
    }

    public function render(ResourceObject $resourceObject)
    {
        $state = $resourceObject->body['state'] ?? [];
        $metas = $resourceObject->body['metas'] ?? [];
        $html = $this->baracoa->render($this->appName, $state, $metas);
        $resourceObject->view = $html;

        return $html;
    }
}
