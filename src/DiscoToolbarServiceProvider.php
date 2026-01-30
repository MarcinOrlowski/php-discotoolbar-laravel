<?php

declare(strict_types=1);

/* **********************************************************************
 *
 *     █▀▀▄  ▀                     ▀▀█▀▀           ▀█  █
 *     █  █ ▀█  ▄▀▀▄ ▄▀▀▄ ▄▀▀▄       █   ▄▀▀▄ ▄▀▀▄  █  █▀▀▄ ▄▀▀▄ █▄▀
 *     █  █  █   ▀▄  █    █  █       █   █  █ █  █  █  █  █  ▄▄█ █
 *     █▄▄▀ ▄█▄ ▀▄▄▀ ▀▄▄▀ ▀▄▄▀       █   ▀▄▄▀ ▀▄▄▀ ▄█▄ █▄▄▀ ▀▄▄▀ █
 *
 * *******  Customizable developer toolbar for Laravel projects  ********
 *
 * @author    Marcin Orlowski <mail (#) marcinOrlowski (.) com>
 * @copyright 2025-2026 Marcin Orlowski
 * @license   https://opensource.org/license/mit MIT
 * @link      https://github.com/MarcinOrlowski/php-discotoolbar-laravel
 *
 * ******************************************************************* */

namespace MarcinOrlowski\DiscoToolbar;

use Illuminate\Foundation\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use MarcinOrlowski\DiscoToolbar\Middleware\InjectDiscoToolbar;
use MarcinOrlowski\DiscoToolbar\Service\DiscoToolbarService;

class DiscoToolbarServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(DiscoToolbarService::class, function ($app) {
            return new DiscoToolbarService(base_path());
        });
    }

    public function boot(): void
    {
        // Only activate when debug mode is enabled
        if (!config('app.debug')) {
            return;
        }

        // Register views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'disco-toolbar');

        // Register middleware at the end of web group
        /** @var Kernel $kernel */
        $kernel = $this->app->make(Kernel::class);
        $kernel->appendMiddlewareToGroup('web', InjectDiscoToolbar::class);
    }
}
