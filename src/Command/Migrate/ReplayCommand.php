<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace Spiral\Command\Migrate;

use Spiral\Console\Console;
use Symfony\Component\Console\Input\InputOption;

final class ReplayCommand extends AbstractCommand
{
    const NAME        = 'migrate:replay';
    const DESCRIPTION = 'Replay (down, up) one or multiple migrations';
    const OPTIONS     = [
        ['all', 'a', InputOption::VALUE_NONE, 'Replay all migrations.']
    ];

    /**
     * @param Console $console
     * @throws \Throwable
     */
    public function perform(Console $console)
    {
        if (!$this->verifyEnvironment()) {
            //Making sure we can safely migrate in this environment
            return;
        }

        $rollback = ['--force' => true];
        $migrate = ['--force' => true];

        if ($this->option('all')) {
            $rollback['--all'] = true;
        } else {
            $migrate['--one'] = true;
        }

        $this->writeln("Rolling back executed migration(s)...");
        $console->run('migrate:rollback', $rollback, $this->output);

        $this->writeln("");

        $this->writeln("Executing outstanding migration(s)...");
        $console->run('migrate', $migrate, $this->output);
    }
}
