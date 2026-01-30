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

namespace MarcinOrlowski\DiscoToolbar\Dto;

class DiscoToolbarData
{
    /**
     * @param array<Widget> $left
     * @param array<Widget> $right
     */
    public function __construct(
        public readonly array $left,
        public readonly array $right,
        public readonly bool $leftExpand,
        public readonly bool $rightExpand,
        public readonly bool $hasError = false,
        public readonly string $errorMessage = '',
        public readonly ?string $version = null,
        public readonly bool $fontAwesomeEnabled = false,
        public readonly string $fontAwesomeVersion = '6.5.1',
        public readonly string $bgColorLight = '#b71c1c',
        public readonly string $bgColorDark = '#8e0000'
    ) {
    }
}
