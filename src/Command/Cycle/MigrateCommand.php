<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace Spiral\Command\Cycle;

use Cycle\Migrations\GenerateMigrations;
use Cycle\ORM\Schema;
use Cycle\Schema\Compiler;
use Cycle\Schema\Registry;
use Spiral\Boot\MemoryInterface;
use Spiral\Bootloader\Cycle\CycleBootloader;
use Spiral\Bootloader\Cycle\SchemaBootloader;
use Spiral\Command\Cycle\Generator\ShowChanges;
use Spiral\Command\Migrate\AbstractCommand;
use Spiral\Console\Console;
use Spiral\Core\Container;
use Spiral\Migrations\Migrator;
use Spiral\Migrations\State;
use Symfony\Component\Console\Input\InputOption;

final class MigrateCommand extends AbstractCommand
{
    public const NAME        = "cycle:migrate";
    public const DESCRIPTION = "Generate ORM schema migrations";

    const OPTIONS = [
        ['run', 'r', InputOption::VALUE_NONE, 'Automatically run generated migration.']
    ];

    /**
     * @param SchemaBootloader   $bootloader
     * @param Container          $container
     * @param CycleBootloader    $cycleBootloader
     * @param Registry           $registry
     * @param MemoryInterface    $memory
     * @param GenerateMigrations $migrations
     * @param Migrator           $migrator
     * @param Console            $console
     *
     * @throws \Throwable
     */
    public function perform(
        SchemaBootloader $bootloader,
        Container $container,
        CycleBootloader $cycleBootloader,
        Registry $registry,
        MemoryInterface $memory,
        GenerateMigrations $migrations,
        Migrator $migrator,
        Console $console
    ) {
        if (!$this->verifyConfigured()) {
            return;
        }

        foreach ($migrator->getMigrations() as $migration) {
            if ($migration->getState()->getStatus() !== State::STATUS_EXECUTED) {
                $this->writeln("<fg=red>Outstanding migrations found, run `migrate` first.</fg=red>");
                return;
            }
        }

        $show = new ShowChanges($this->output);

        $schema = (new Compiler())->compile(
            $registry,
            array_merge($bootloader->getGenerators(), [$show])
        );

        $memory->saveData('cycle', $schema);

        if ($show->hasChanges()) {
            (new Compiler())->compile($registry, [$migrations]);

            if ($this->option('run')) {
                $console->run('migrate', [], $this->output);
            }
        }

        $cycleBootloader->bindRepositories($container, new Schema($schema));
    }
}
