<?php

declare(strict_types=1);

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Framework\Http;

use PHPUnit\Framework\TestCase;
use Spiral\Http\Diactoros\ServerRequestFactory;

class RequestFactoryTest extends TestCase
{
    public function testCreateRequest(): void
    {
        $r = (new ServerRequestFactory())->createServerRequest('GET', '/home');
        $this->assertSame('GET', $r->getMethod());
        $this->assertSame('/home', $r->getUri()->getPath());
    }
}
