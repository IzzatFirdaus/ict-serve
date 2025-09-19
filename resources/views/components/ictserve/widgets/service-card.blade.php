@props([
  'title',
  'description' => null,
  'icon' => null,
  'iconColor' => 'primary',
  'href' => null,
  'actions' => null,
  'badge' => null,
  'badgeVariant' => 'primary',
  'disabled' => false,
])

@php
  $iconColorClasses = [
    'primary' => 'text-txt-primary bg-primary-50',
    'accent' => 'text-txt-accent bg-accent-50',
    'success' => 'text-txt-success bg-success-50',
    'warning' => 'text-txt-warning bg-warning-50',
    'danger' => 'text-txt-danger bg-danger-50',
    'gray' => 'text-txt-black-700 bg-gray-100',
  ];

  $badgeVariantClasses = [
    'primary' => 'bg-primary-100 text-txt-primary',
    'accent' => 'bg-accent-100 text-txt-accent',
    'success' => 'bg-success-100 text-txt-success',
    'warning' => 'bg-warning-100 text-txt-warning',
    'danger' => 'bg-danger-100 text-txt-danger',
    'gray' => 'bg-gray-100 text-txt-black-600',
  ];

  $component = $href && ! $disabled ? 'a' : 'div';
  $componentClass = 'bg-white dark:bg-dialog overflow-hidden shadow-card rounded-lg border border-otl-divider transition-all duration-200';

  if ($href && ! $disabled) {
    $componentClass .= ' hover:shadow-md hover:border-primary-200 group cursor-pointer';
  } elseif ($disabled) {
    $componentClass .= ' opacity-60 cursor-not-allowed';
  }
@endphp

<{{ $component }}
  @if($href && !$disabled) href="{{ $href }}" @endif
  class="{{ $componentClass }}"
  {{ $attributes }}
  @if($disabled) aria-disabled="true" @endif
  role="{{ $href && ! $disabled ? 'link' : 'article' }}"
  aria-labelledby="service-{{ \Str::slug($title ?? 'service') }}-title"
>
  <div class="p-6">
    <div class="flex items-start justify-between">
      {{-- Main Content --}}
      <div class="flex items-start flex-1">
        {{-- Icon --}}
        @if ($icon)
          <div class="flex-shrink-0 mr-4">
            <div
              class="h-12 w-12 rounded-lg flex items-center justify-center {{ $iconColorClasses[$iconColor] ?? $iconColorClasses['primary'] }}"
              aria-hidden="true"
            >
              {!! $icon !!}
            </div>
          </div>
        @endif

        {{-- Text Content --}}
        <div class="flex-1 min-w-0">
          <div class="flex items-center justify-between">
            <h3
              id="service-{{ \Str::slug($title ?? 'service') }}-title"
              class="text-lg font-poppins font-semibold text-txt-black-900 {{ $href && ! $disabled ? 'group-hover:text-txt-primary' : '' }}"
            >
              {{ $title }}
            </h3>

            {{-- Badge --}}
            @if ($badge)
              <span
                class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeVariantClasses[$badgeVariant] ?? $badgeVariantClasses['primary'] }}"
              >
                {{ $badge }}
              </span>
            @endif
          </div>

          {{-- Description --}}
          @if ($description)
            <p class="mt-2 text-sm text-txt-black-700 leading-relaxed">
              {{ $description }}
            </p>
          @endif

          {{-- Additional Content Slot --}}
          @if (isset($content))
            <div class="mt-3">
              {{ $content }}
            </div>
          @endif
        </div>
      </div>

      {{-- Action Arrow --}}
      @if ($href && ! $disabled)
        <div class="flex-shrink-0 ml-4">
          <svg
            class="h-5 w-5 text-txt-black-400 group-hover:text-txt-primary transition-colors"
            viewBox="0 0 20 20"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M7 5l6 5-6 5"
            />
          </svg>
        </div>
      @endif
    </div>

    {{-- Actions --}}
    @if ($actions && ! $disabled)
      <div class="mt-6 pt-4 border-t border-otl-divider">
        <div class="flex items-center justify-between">
          {{ $actions }}
        </div>
      </div>
    @endif

    {{-- Bottom Slot --}}
    @if (isset($slot) && ! empty(trim($slot)))
      <div class="mt-4">
        {{ $slot }}
      </div>
    @endif
  </div>
</{{ $component }}>
