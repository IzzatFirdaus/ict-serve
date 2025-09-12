@props([
    'message' => '',
    'position' => 'top',
    'trigger' => 'hover',
    'delay' => 0,
    'offset' => 8,
])

@php
    $positionClasses = match($position) {
        'top' => 'bottom-full left-1/2 transform -translate-x-1/2 mb-' . $offset,
        'bottom' => 'top-full left-1/2 transform -translate-x-1/2 mt-' . $offset,
        'left' => 'right-full top-1/2 transform -translate-y-1/2 mr-' . $offset,
        'right' => 'left-full top-1/2 transform -translate-y-1/2 ml-' . $offset,
        default => 'bottom-full left-1/2 transform -translate-x-1/2 mb-' . $offset
    };

    $arrowClasses = match($position) {
        'top' => 'top-full left-1/2 transform -translate-x-1/2 border-l-transparent border-r-transparent border-b-transparent border-t-gray-900',
        'bottom' => 'bottom-full left-1/2 transform -translate-x-1/2 border-l-transparent border-r-transparent border-t-transparent border-b-gray-900',
        'left' => 'left-full top-1/2 transform -translate-y-1/2 border-t-transparent border-b-transparent border-r-transparent border-l-gray-900',
        'right' => 'right-full top-1/2 transform -translate-y-1/2 border-t-transparent border-b-transparent border-l-transparent border-r-gray-900',
        default => 'top-full left-1/2 transform -translate-x-1/2 border-l-transparent border-r-transparent border-b-transparent border-t-gray-900'
    };

    $triggerEvent = $trigger === 'click' ? '@click' : '@mouseenter';
    $hideEvent = $trigger === 'click' ? '@click.away' : '@mouseleave';
@endphp

<div
    class="relative inline-block"
    x-data="{
        show: false,
        timeout: null,
        showTooltip() {
            if (this.timeout) clearTimeout(this.timeout);
            @if($delay > 0)
                this.timeout = setTimeout(() => this.show = true, {{ $delay }});
            @else
                this.show = true;
            @endif
        },
        hideTooltip() {
            if (this.timeout) clearTimeout(this.timeout);
            this.show = false;
        }
    }"
    {{ $triggerEvent }}="showTooltip()"
    {{ $hideEvent }}="hideTooltip()"
    {{ $attributes }}
>
    <!-- Trigger Element -->
    {{ $slot }}

    <!-- Tooltip -->
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute z-50 {{ $positionClasses }}"
        style="display: none;"
        role="tooltip"
    >
        <!-- Tooltip Content -->
        <div class="px-3 py-2 text-sm text-white bg-gray-900 rounded-md shadow-lg max-w-xs break-words">
            {{ $message }}
        </div>

        <!-- Tooltip Arrow -->
        <div class="absolute w-0 h-0 {{ $arrowClasses }}" style="border-width: 6px;"></div>
    </div>
</div>
