<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace Spiral\Command\GRPC;

use Spiral\Console\Command;
use Spiral\GRPC\LocatorInterface;

final class ListCommand extends Command
{
    protected const NAME        = "grpc:services";
    protected const DESCRIPTION = "List available GRPC services";

    /**
     * @param LocatorInterface $locator
     */
    public function perform(LocatorInterface $locator)
    {
        $services = $locator->getServices();

        if ($services === []) {
            $this->writeln("<comment>No GRPC services were found.</comment>");
            return;
        }

        $grid = $this->table([
            'Service:',
            'Implementation:',
            'File:',
        ]);

        foreach ($services as $interface => $instance) {
            $grid->addRow([
                $interface::NAME,
                get_class($instance),
                (new \ReflectionObject($instance))->getFileName()
            ]);
        }

        $grid->render();
    }
}
