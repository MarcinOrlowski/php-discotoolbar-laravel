{{-- DiscoToolbar Template --}}
{{-- This template displays DiscoToolbar with links to various tools and information --}}

<style>
    /* DiscoToolbar for development environment */
    :root {
        /* Single source of truth for the toolbar height. Referenced by the bar
           itself and by the spacer/offset rules so the value can't drift. */
        --disco-toolbar-height: 40px;
    }

    .disco-toolbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1001;
        background: var(--bg-color-dark, #8e0000);
        color: white;
        font-size: 15px;
        overflow: hidden;
    }

    .disco-toolbar::before {
        content: '';
        position: absolute;
        inset: 0;
        background: repeating-linear-gradient(
            45deg,
            var(--bg-color-light, #b71c1c),
            var(--bg-color-light, #b71c1c) 10px,
            var(--bg-color-dark, #8e0000) 10px,
            var(--bg-color-dark, #8e0000) 20px
        );
        animation: disco-toolbar-breathe 6s ease-in-out infinite;
    }

    @keyframes disco-toolbar-breathe {
        0%, 100% {
            opacity: 0.3;
            transform: scale(1);
        }
        50% {
            opacity: 1;
            transform: scale(1.05);
        }
    }

    .disco-toolbar-error {
        background: #d32f2f;
    }

    .disco-toolbar-error::before {
        background: repeating-linear-gradient(
            45deg,
            #d32f2f,
            #d32f2f 10px,
            #ff5722 10px,
            #ff5722 20px
        );
    }

    .disco-toolbar-content {
        position: relative;
        max-width: 1100px;
        margin: 0 auto;
        display: flex;
        flex-wrap: nowrap;
        justify-content: space-between;
        align-items: center;
        height: var(--disco-toolbar-height);
        min-height: var(--disco-toolbar-height);
        overflow: hidden;
    }

    .disco-toolbar-container-left {
        display: flex;
        align-items: center;
        white-space: nowrap;
        overflow: hidden;
        flex: 0 0 auto;
        justify-content: flex-start;
    }

    .disco-toolbar-container-left.disco-toolbar-container-expand {
        flex: 1 1 auto;
        min-width: 0;
    }

    .disco-toolbar-container-right {
        display: flex;
        align-items: center;
        white-space: nowrap;
        overflow: hidden;
        flex: 0 0 auto;
        justify-content: flex-end;
    }

    .disco-toolbar-container-right.disco-toolbar-container-expand {
        flex: 1 1 auto;
        min-width: 0;
    }

    .disco-toolbar-widget {
        display: inline-flex;
        align-items: center;
        flex-shrink: 0;
    }

    .disco-toolbar-widget-expand {
        flex: 1 1 0;
        min-width: 0;
    }

    .disco-toolbar-link {
        color: white;
        text-decoration: none;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        line-height: 1;
    }

    .disco-toolbar-link-content {
        display: inline-flex;
        align-items: center;
        padding: 6px 8px;
        transition: all 0.2s ease;
    }

    .disco-toolbar-link:hover .disco-toolbar-link-content {
        background-color: orange;
        color: black;
        text-decoration: underline;
    }

    .disco-toolbar-separator {
        margin: 0 2px;
    }

    .disco-toolbar-link-content i {
        margin-right: 4px;
    }

    .disco-toolbar-text {
        color: white;
        font-weight: normal;
        padding: 6px 8px;
    }

    /* Reserve space so the fixed bar doesn't overlap page content. */
    body:has(.disco-toolbar) {
        padding-top: var(--disco-toolbar-height);
    }

    /* Offset elements pinned to the very top (e.g. sticky navbars) so they sit
       below the toolbar instead of sliding under it on scroll. Targets the
       common Tailwind `sticky top-0` convention; a no-op for apps without it. */
    body:has(.disco-toolbar) .sticky.top-0 {
        top: var(--disco-toolbar-height);
    }
</style>

@if($data->fontAwesomeEnabled)
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/{{ $data->fontAwesomeVersion }}/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
@endif

<div class="disco-toolbar @if($data->hasError) disco-toolbar-error @endif" style="--bg-color-light: {{ $data->bgColorLight }}; --bg-color-dark: {{ $data->bgColorDark }}">
    <div class="disco-toolbar-content">
        @if($data->hasError)
            <div class="disco-toolbar-container-left">
                <span class="disco-toolbar-widget">
                    <a href="https://github.com/MarcinOrlowski/php-discotoolbar-laravel" class="disco-toolbar-link" target="_blank" title="Visit DiscoToolbar on GitHub">
                        <span class="disco-toolbar-link-content">DiscoToolbar</span>
                    </a>
                </span>
                <span class="disco-toolbar-separator">&middot;</span>
                <span class="disco-toolbar-widget">
                    <span class="disco-toolbar-text">v{{ $data->version ?? 'N/A' }} * {{ $data->errorMessage }}</span>
                </span>
            </div>
        @else
            <div class="disco-toolbar-container-left @if($data->leftExpand) disco-toolbar-container-expand @endif">
                @foreach($data->left as $widget)
                    @unless($loop->first)
                        <span class="disco-toolbar-separator">&middot;</span>
                    @endunless
                    @if($widget->type === 'close')
                        <span class="disco-toolbar-widget">
                            <a href="#" class="disco-toolbar-link" onclick="document.querySelector('.disco-toolbar').remove(); return false;" title="Close Toolbar">
                                <span class="disco-toolbar-link-content">✕</span>
                            </a>
                        </span>
                    @else
                        <span class="disco-toolbar-widget @if($widget->expand) disco-toolbar-widget-expand @endif">
                            <a href="{{ $widget->url }}"
                               class="disco-toolbar-link"
                               @if($widget->target) target="{{ $widget->target }}" @endif
                               @if($widget->title) title="{{ $widget->title }}" @endif>
                                <span class="disco-toolbar-link-content">
                                    @if($widget->icon)
                                        @if($widget->iconType->value === 'fa')
                                            <i class="{{ $widget->icon }}"></i>
                                        @else
                                            {{ $widget->icon }}
                                        @endif
                                    @endif
                                    @if($widget->text){{ $widget->text }}@endif
                                </span>
                            </a>
                        </span>
                    @endif
                @endforeach
            </div>
            <div class="disco-toolbar-container-right @if($data->rightExpand) disco-toolbar-container-expand @endif">
                @foreach($data->right as $widget)
                    @unless($loop->first)
                        <span class="disco-toolbar-separator">&middot;</span>
                    @endunless
                    @if($widget->type === 'close')
                        <span class="disco-toolbar-widget">
                            <a href="#" class="disco-toolbar-link" onclick="document.querySelector('.disco-toolbar').remove(); return false;" title="Close Toolbar">
                                <span class="disco-toolbar-link-content">✕</span>
                            </a>
                        </span>
                    @else
                        <span class="disco-toolbar-widget @if($widget->expand) disco-toolbar-widget-expand @endif">
                            <a href="{{ $widget->url }}"
                               class="disco-toolbar-link"
                               @if($widget->target) target="{{ $widget->target }}" @endif
                               @if($widget->title) title="{{ $widget->title }}" @endif>
                                <span class="disco-toolbar-link-content">
                                    @if($widget->icon)
                                        @if($widget->iconType->value === 'fa')
                                            <i class="{{ $widget->icon }}"></i>
                                        @else
                                            {{ $widget->icon }}
                                        @endif
                                    @endif
                                    @if($widget->text){{ $widget->text }}@endif
                                </span>
                            </a>
                        </span>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
