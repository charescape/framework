<?php

declare(strict_types=1);

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\App\ViewEngine;

use Spiral\Views\ViewInterface;
use Spiral\Views\ViewSource;

class View implements ViewInterface
{
    private $source;

    public function __construct(ViewSource $source)
    {
        $this->source = $source;
    }

    public function render(array $data = []): string
    {
        return $this->source->getCode();
    }
}
