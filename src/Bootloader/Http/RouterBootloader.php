<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace Spiral\Bootloader\Http;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Core\Core;
use Spiral\Core\CoreInterface;
use Spiral\Http\Config\HttpConfig;
use Spiral\Router\Router;
use Spiral\Router\RouterInterface;
use Spiral\Router\UriHandler;

final class RouterBootloader extends Bootloader
{
    const DEPENDENCIES = [
        HttpBootloader::class
    ];

    const SINGLETONS = [
        CoreInterface::class           => Core::class,
        RouterInterface::class         => [self::class, 'router'],
        RequestHandlerInterface::class => RouterInterface::class,
    ];

    /**
     * @param HttpConfig         $config
     * @param UriHandler         $uriHandler
     * @param ContainerInterface $container
     * @return RouterInterface
     */
    protected function router(
        HttpConfig $config,
        UriHandler $uriHandler,
        ContainerInterface $container
    ): RouterInterface {
        return new Router($config->getBasePath(), $uriHandler, $container);
    }
}
