{{--
    MYDS Tooltip for ICTServe (iServe)
    - Props:
    message: string
    position: top|bottom|left|right
    trigger: hover|click
    delay: ms
    offset: px (numeric)
    - A11y: role=tooltip, keyboard-friendly with click trigger, transitions
--}}

@props([
    "message" => "",
    "position" => "top",
    "trigger" => "hover",
    "delay" => 0,
    "offset" => 8,
])

@php
  $posStyle = match ($position) {
      "bottom" => "top:100%; left:50%; transform:translateX(-50%); margin-top: {$offset}px;",
      "left" => "right:100%; top:50%; transform:translateY(-50%); margin-right: {$offset}px;",
      "right" => "left:100%; top:50%; transform:translateY(-50%); margin-left: {$offset}px;",
      default => "bottom:100%; left:50%; transform:translateX(-50%); margin-bottom: {$offset}px;", // top
  };

  $triggerEvent = $trigger === "click" ? "@click" : "@mouseenter";
  $hideEvent = $trigger === "click" ? "@click.outside" : "@mouseleave";

  $arrowBorder = "var(--bg-black-900)"; // token variable
@endphp

<div
  class="relative inline-block"
  x-data="{
            show: false,
            timeout: null,
            showTooltip() {
                    if (this.timeout) clearTimeout(this.timeout);
                    @if ($delay > 0)
                        this.timeout
                        =
                        setTimeout(()
                        =>
                        this.show
                        =
                        true,
                        {{ (int) $delay }});
                    @else
                        this.show
                        =
                        true;
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
  {{ $slot }}

  <div
    x-show="show"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    class="absolute z-50"
    style="{{ $posStyle }}"
    x-cloak
    role="tooltip"
  >
    <div
      class="px-3 py-2 text-sm txt-white"
      style="
        background-color: var(--bg-black-900);
        border-radius: var(--radius-m);
        box-shadow: var(--shadow-context-menu);
        max-width: 280px;
        word-break: break-word;
      "
    >
      {{ $message }}
    </div>

    {{-- Arrow --}}

    @switch($position)
      @case("bottom")
        <div
          style="
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-bottom: 6px solid {{ $arrowBorder }};
          "
        ></div>

        @break
      @case("left")
        <div
          style="
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-top: 6px solid transparent;
            border-bottom: 6px solid transparent;
            border-left: 6px solid {{ $arrowBorder }};
          "
        ></div>

        @break
      @case("right")
        <div
          style="
            position: absolute;
            right: 100%;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-top: 6px solid transparent;
            border-bottom: 6px solid transparent;
            border-right: 6px solid {{ $arrowBorder }};
          "
        ></div>

        @break
      @default
        <div
          style="
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 6px solid {{ $arrowBorder }};
          "
        ></div>
    @endswitch
  </div>
</div>
