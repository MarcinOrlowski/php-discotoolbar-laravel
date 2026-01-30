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

namespace MarcinOrlowski\DiscoToolbar\Service;

use Composer\InstalledVersions;
use MarcinOrlowski\DiscoToolbar\Dto\DiscoToolbarData;
use MarcinOrlowski\DiscoToolbar\Dto\Widget;
use Symfony\Component\Yaml\Yaml;

class DiscoToolbarService
{
    private const CONFIG_FILES = [
        '.disco.yaml',
        '.disco.yml',
    ];

    private const DEFAULT_FONT_AWESOME_VERSION = '6.5.1';
    private const DEFAULT_BG_COLOR_LIGHT = '#b71c1c';
    private const DEFAULT_BG_COLOR_DARK = '#8e0000';

    public function __construct(
        private readonly string $basePath
    ) {
    }

    public function getDiscoToolbarData(): DiscoToolbarData
    {
        $configPath = $this->findConfigFile();
        $version = $this->getVersion();

        if ($configPath === null) {
            $errorMessage = 'Config file not found: ' . self::CONFIG_FILES[0];
            return new DiscoToolbarData(
                left:                [],
                right:               [],
                leftExpand:          false,
                rightExpand:         false,
                hasError:            true,
                errorMessage:        $errorMessage,
                version:             $version,
                fontAwesomeEnabled:  false,
                fontAwesomeVersion:  self::DEFAULT_FONT_AWESOME_VERSION,
                bgColorLight:        self::DEFAULT_BG_COLOR_LIGHT,
                bgColorDark:         self::DEFAULT_BG_COLOR_DARK
            );
        }

        $config = Yaml::parseFile($configPath);

        if (!\is_array($config)) {
            $config = [];
        }

        $fontAwesomeConfig = $config['font_awesome'] ?? [];
        $fontAwesomeEnabled = false;
        $fontAwesomeVersion = self::DEFAULT_FONT_AWESOME_VERSION;

        if (\is_array($fontAwesomeConfig)) {
            $fontAwesomeEnabled = $fontAwesomeConfig['enabled'] ?? false;
            $userVersion = $fontAwesomeConfig['version'] ?? null;
            if ($userVersion !== null && \is_string($userVersion)) {
                $fontAwesomeVersion = $userVersion;
            }
        }

        $widgets = $config['widgets'] ?? [];
        if (!\is_array($widgets)) {
            $widgets = [];
        }

        $left = $widgets['left'] ?? [];
        $right = $widgets['right'] ?? [];

        $leftWidgets = $this->loadWidgets(\is_array($left) ? $left : []);
        $rightWidgets = $this->loadWidgets(\is_array($right) ? $right : []);

        $bgColorLight = $config['bg_color_light'] ?? self::DEFAULT_BG_COLOR_LIGHT;
        $bgColorDark = $config['bg_color_dark'] ?? self::DEFAULT_BG_COLOR_DARK;

        return new DiscoToolbarData(
            left:                $leftWidgets,
            right:               $rightWidgets,
            leftExpand:          $this->hasExpandingWidget($leftWidgets),
            rightExpand:         $this->hasExpandingWidget($rightWidgets),
            hasError:            false,
            errorMessage:        '',
            version:             $version,
            fontAwesomeEnabled:  \is_bool($fontAwesomeEnabled) ? $fontAwesomeEnabled : false,
            fontAwesomeVersion:  $fontAwesomeVersion,
            bgColorLight:        \is_string($bgColorLight) ? $bgColorLight : self::DEFAULT_BG_COLOR_LIGHT,
            bgColorDark:         \is_string($bgColorDark) ? $bgColorDark : self::DEFAULT_BG_COLOR_DARK
        );
    }

    private function findConfigFile(): ?string
    {
        foreach (self::CONFIG_FILES as $filename) {
            $path = $this->basePath . '/' . $filename;
            if (\file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * @param array<Widget> $widgets
     */
    private function hasExpandingWidget(array $widgets): bool
    {
        foreach ($widgets as $widget) {
            if ($widget->expand) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array<mixed> $widgetsData
     * @return array<Widget>
     */
    private function loadWidgets(array $widgetsData): array
    {
        return \array_map(
            function ($widgetData): Widget {
                /** @var array<string, mixed> $data */
                $data = \is_array($widgetData) ? $widgetData : [];
                return Widget::fromArray($data);
            },
            $widgetsData
        );
    }

    public const DEV_VERSION = 'dev';

    private function getVersion(): string
    {
        try {
            $version = InstalledVersions::getVersion('marcin-orlowski/disco-toolbar-laravel');
            return $version ?? self::DEV_VERSION ;
        } catch (\Exception $e) {
            return self::DEV_VERSION;
        }
    }
}
