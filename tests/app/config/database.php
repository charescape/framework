<?php

declare(strict_types=1);

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
use Spiral\Database\Driver;

return [
    'default'   => 'default',
    'databases' => [
        'default' => ['driver' => 'runtime'],
    ],
    'drivers'   => [
        'runtime' => [
            'driver'     => Driver\SQLite\SQLiteDriver::class,
            'connection' => 'sqlite::memory:',
            'profiling'  => true,
        ],
        'other'   => [
            'driver'     => Driver\Postgres\PostgresDriver::class,
            'connection' => 'pgsql:host=327.0.0.1;dbname=database',
            'profiling'  => true,
        ],
    ]
];
