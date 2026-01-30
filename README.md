![img](img/banner.webp)

[![Latest Stable Version](https://poser.pugx.org/marcin-orlowski/disco-toolbar-laravel/v)](https://packagist.org/packages/marcin-orlowski/disco-toolbar-laravel)
[![Monthly Downloads](https://poser.pugx.org/marcin-orlowski/disco-toolbar-laravel/d/monthly)](https://packagist.org/packages/marcin-orlowski/disco-toolbar-laravel)
[![License](https://poser.pugx.org/marcin-orlowski/disco-toolbar-laravel/license)](https://packagist.org/packages/marcin-orlowski/disco-toolbar-laravel)

# Welcome!

**DiscoToolbar** is a customizable toolbar for your Laravel application, providing all-time access to
essential resources right from your browser. Perfect for streamlining your workflow by keeping
frequently-used tools, admin panels, and services just one click away.

## What is DiscoToolbar?

DiscoToolbar creates a persistent banner (typically placed at the top of your layout) that displays
during development. It's highly configurable via YAML, allowing you to create custom buttons and
links to anything you need: admin panels, database tools, email catchers, API documentation, or
any other resource.

![img](img/disco-toolbar.webp)

### Perfect for Docker Environments

Since configuration is YAML-based, it's incredibly easy to generate dynamically when setting up new
environments. When using Docker or similar containerization, port numbers often change between
setups - but with DiscoToolbar, you can regenerate the configuration file on each environment
startup, ensuring all links always point to the correct ports and services.

## Features

- **Zero configuration** - Works out of the box with Laravel's auto-discovery
- **Fully customizable via YAML** - Easy to configure and regenerate for different environments
- **Flexible widget system** - Create buttons with Font Awesome icons, emoji, text labels, or any combination
- **Display anything** - Add links to admin panels, database tools, email catchers, API docs, or any resource
- **Action buttons** - Direct access to frequently-used tools and services
- **Debug-aware** - Only loads when `APP_DEBUG=true`, zero production overhead
- **Dynamic configuration** - Perfect for Docker setups where ports change - regenerate config on startup
- **Customizable placement** - Position widgets on left or right side of the toolbar

See [extensive documentation](docs/) for details and usage examples.

## Requirements

- PHP 8.2 or higher
- Laravel 11.x or 12.x

## Notes

There's also [Symfony version](https://github.com/MarcinOrlowski/php-discotoolbar-symfony) of this package! 

[![x](img/banner-symfony.webp)](https://github.com/MarcinOrlowski/php-discotoolbar-symfony)

## License

- Written and copyrighted &copy;2025-2026 by Marcin Orlowski <mail (#) marcinorlowski (.) com>
- DiscoToolbar is open-source software licensed under
  the [MIT license](http://opensource.org/licenses/MIT)
