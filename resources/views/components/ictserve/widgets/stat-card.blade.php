@props([
  'title',
  'value' => null,
  'subtitle' => null,
  'icon' => null,
  'iconColor' => 'primary',
  'trend' => null,
  'trendDirection' => null,
  // 'up',
  'down',
  'neutral',
  'href' => null,
  'loading' => false,
])

@php
  $iconColorClasses = [
    'primary' => 'text-txt-primary bg-primary-50',
    'accent' => 'text-txt-accent bg-accent-50',
    'success' => 'text-txt-success bg-success-50',
    'warning' => 'text-txt-warning bg-warning-50',
    'danger' => 'text-txt-danger bg-danger-50',
  ];

  $trendColorClasses = [
    'up' => 'text-txt-success',
    'down' => 'text-txt-danger',
    'neutral' => 'text-txt-black-500',
  ];

  $component = $href ? 'a' : 'div';
@endphp

<{{ $component }}
  @if($href) href="{{ $href }}" @endif
  class="bg-white dark:bg-dialog overflow-hidden shadow-card rounded-lg border border-otl-divider {{ $href ? 'hover:shadow-md transition-shadow duration-200 hover:border-primary-200' : '' }}"
  {{ $attributes }}
  role="{{ $href ? 'link' : 'group' }}"
  aria-labelledby="stat-{{ \Str::slug($title ?? 'stat') }}-title"
>
  <div class="p-6">
    {{-- Loading State --}}
    @if ($loading)
      <div class="animate-pulse" aria-busy="true" aria-live="polite">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div
              class="h-12 w-12 bg-gray-200 dark:bg-gray-700 rounded-lg"
              aria-hidden="true"
            ></div>
          </div>
          <div class="ml-4 flex-1">
            <div
              class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-3/4 mb-2"
              aria-hidden="true"
            ></div>
            <div
              class="h-8 bg-gray-200 dark:bg-gray-700 rounded w-1/2"
              aria-hidden="true"
            ></div>
          </div>
        </div>
      </div>
    @else
      <div class="flex items-center">
        {{-- Icon --}}
        @if ($icon)
          <div class="flex-shrink-0">
            <div
              class="h-12 w-12 rounded-lg flex items-center justify-center {{ $iconColorClasses[$iconColor] ?? $iconColorClasses['primary'] }}"
              aria-hidden="true"
            >
              {!! $icon !!}
            </div>
          </div>
        @endif

        {{-- Content --}}
        <div class="ml-4 flex-1">
          {{-- Title --}}
          <p
            id="stat-{{ \Str::slug($title ?? 'stat') }}-title"
            class="text-sm font-medium text-txt-black-600 truncate"
          >
            {{ $title }}
          </p>

          {{-- Value --}}
          @if ($value !== null)
            <p class="text-3xl font-bold text-txt-black-900 mt-1">
              {{ $value }}
            </p>
          @endif

          {{-- Subtitle --}}
          @if ($subtitle)
            <p class="text-xs text-txt-black-500 mt-1">
              {{ $subtitle }}
            </p>
          @endif

          {{-- Trend --}}
          @if ($trend && $trendDirection)
            <div
              class="flex items-center mt-2"
              aria-hidden="false"
              role="status"
            >
              @if ($trendDirection === 'up')
                <svg
                  class="h-4 w-4 {{ $trendColorClasses[$trendDirection] }}"
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
                    d="M6 14l6-8 4 5"
                  />
                </svg>
              @elseif ($trendDirection === 'down')
                <svg
                  class="h-4 w-4 {{ $trendColorClasses[$trendDirection] }}"
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
                    d="M14 6l-6 8-4-5"
                  />
                </svg>
              @else
                <svg
                  class="h-4 w-4 {{ $trendColorClasses[$trendDirection] }}"
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
                    d="M4 10h12"
                  />
                </svg>
              @endif
              <span
                class="ml-2 text-sm font-medium {{ $trendColorClasses[$trendDirection] }}"
              >
                {{ $trend }}
              </span>
              {{-- Non-colour accessible label for screen readers --}}
              <span class="sr-only">
                {{ $trendDirection === 'up' ? 'menaik' : ($trendDirection === 'down' ? 'menurun' : 'stabil') }}
              </span>
            </div>
          @endif
        </div>

        {{-- Arrow for links --}}
        @if ($href)
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

      {{-- Slot for additional content --}}
      @if (isset($slot) && ! empty(trim($slot)))
        <div class="mt-4 pt-4 border-t border-otl-divider">
          {{ $slot }}
        </div>
      @endif
    @endif
  </div>
</{{ $component }}>
