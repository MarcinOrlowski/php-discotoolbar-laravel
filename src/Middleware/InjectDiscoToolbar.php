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

namespace MarcinOrlowski\DiscoToolbar\Middleware;

use Closure;
use Illuminate\Http\Request;
use MarcinOrlowski\DiscoToolbar\Service\DiscoToolbarService;
use Symfony\Component\HttpFoundation\Response;

class InjectDiscoToolbar
{
    public function __construct(
        private readonly DiscoToolbarService $service
    ) {
    }

    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        if (!$this->shouldInject($response)) {
            return $response;
        }

        $content = $response->getContent();
        if ($content === false) {
            return $response;
        }

        $data = $this->service->getDiscoToolbarData();
        $toolbarHtml = view('disco-toolbar::toolbar', ['data' => $data])->render();

        // Inject after <body> tag
        $newContent = preg_replace(
            '/<body([^>]*)>/i',
            '<body$1>' . $toolbarHtml,
            $content,
            1
        );

        if (\is_string($newContent)) {
            $response->setContent($newContent);
        }

        return $response;
    }

    private function shouldInject(Response $response): bool
    {
        // Only inject into HTML responses
        $contentType = $response->headers->get('Content-Type', '');
        if (!\is_string($contentType) || !\str_contains($contentType, 'text/html')) {
            return false;
        }

        // Skip redirects
        if ($response->isRedirection()) {
            return false;
        }

        // Must have content with <body> tag
        $content = $response->getContent();
        if ($content === false || !\str_contains($content, '<body')) {
            return false;
        }

        return true;
    }
}
