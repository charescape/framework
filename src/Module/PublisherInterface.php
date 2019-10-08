<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace Spiral\Module;

use Spiral\Files\FilesInterface;
use Spiral\Module\Exception\PublishException;

/**
 * Provides ability to publish module files such as configs, images and etc.
 */
interface PublisherInterface
{
    // Merge rules
    public const REPLACE = 'replace';
    public const FOLLOW  = 'follow';

    /**
     * Publish single file.
     *
     * @param string $filename
     * @param string $destination
     * @param string $mergeMode
     * @param int    $mode
     *
     * @throws PublishException
     */
    public function publish(
        string $filename,
        string $destination,
        string $mergeMode = self::FOLLOW,
        int $mode = FilesInterface::READONLY
    );

    /**
     * Publish content of specified directory.
     *
     * @param string $directory
     * @param string $destination
     * @param string $mergeMode
     * @param int    $mode
     *
     * @throws PublishException
     */
    public function publishDirectory(
        string $directory,
        string $destination,
        string $mergeMode = self::REPLACE,
        int $mode = FilesInterface::READONLY
    );

    /**
     * Ensure that specified directory exists and has valid file permissions.
     *
     * @param string $directory
     * @param int    $mode
     *
     * @throws PublishException
     */
    public function ensureDirectory(string $directory, int $mode = FilesInterface::READONLY);
}
