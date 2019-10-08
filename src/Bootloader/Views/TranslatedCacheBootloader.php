<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace Spiral\Bootloader\Views;

use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Bootloader\I18nBootloader;
use Spiral\Translator\Views\LocaleDependency;
use Spiral\Translator\Views\LocaleProcessor;

/**
 * Generates unique cache path based on active translator locale.
 */
final class TranslatedCacheBootloader extends Bootloader
{
    const DEPENDENCIES = [
        I18nBootloader::class,
        ViewsBootloader::class
    ];

    const SINGLETONS = [
        // Each engine expect to mount this process by itself
        LocaleProcessor::class => LocaleProcessor::class
    ];

    /**
     * @param ViewsBootloader $views
     */
    public function boot(ViewsBootloader $views)
    {
        $views->addCacheDependency(LocaleDependency::class);
    }
}
