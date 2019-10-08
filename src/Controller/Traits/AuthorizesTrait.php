<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace Spiral\Controller\Traits;

use Spiral\Core\Exception\ControllerException;
use Spiral\Security\Traits\GuardedTrait;

/**
 * Authorizes method and throws an exception in case of failure. Relies on global container scope.
 */
trait AuthorizesTrait
{
    use GuardedTrait;

    /**
     * Authorize permission or thrown controller exception.
     *
     * @param string $permission
     * @param array  $context
     * @return bool
     *
     * @throws ControllerException
     */
    protected function authorize(string $permission, array $context = []): bool
    {
        if (!$this->allows($permission, $context)) {
            $name = $this->resolvePermission($permission);

            throw new ControllerException(
                "Unauthorized permission '{$name}'",
                ControllerException::FORBIDDEN
            );
        }

        return true;
    }
}
