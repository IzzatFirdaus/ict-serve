@props([
  'activities' => [],
  'title' => 'Aktiviti Terkini',
  'showHeader' => true,
  'maxItems' => 5,
  'showViewAll' => true,
  'viewAllUrl' => null,
  'loading' => false,
])

<div
  class="bg-white dark:bg-dialog shadow-card rounded-lg border border-otl-divider"
  {{ $attributes }}
  role="region"
  aria-labelledby="activity-feed-title"
>
  {{-- Header --}}
  @if ($showHeader)
    <header class="px-6 py-4 border-b border-otl-divider">
      <div class="flex items-center justify-between">
        <h3
          id="activity-feed-title"
          class="text-lg font-poppins font-semibold text-txt-black-900"
        >
          {{ $title }}
        </h3>

        @if ($showViewAll && $viewAllUrl)
          <a
            href="{{ $viewAllUrl }}"
            class="text-sm font-medium text-txt-primary hover:text-primary-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded"
          >
            Lihat Semua
          </a>
        @endif
      </div>
    </header>
  @endif

  {{-- Content --}}
  <div class="px-6 py-4">
    @if ($loading)
      {{-- Loading skeleton (accessible) --}}
      <div class="space-y-4" aria-busy="true" aria-live="polite">
        @for ($i = 0; $i < 3; $i++)
          <div class="animate-pulse flex items-start space-x-3">
            <div
              class="h-8 w-8 bg-gray-200 dark:bg-gray-700 rounded-full"
              aria-hidden="true"
            ></div>
            <div class="flex-1 space-y-2">
              <div
                class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-3/4"
                aria-hidden="true"
              ></div>
              <div
                class="h-3 bg-gray-200 dark:bg-gray-700 rounded w-1/2"
                aria-hidden="true"
              ></div>
            </div>
          </div>
        @endfor
      </div>
    @elseif (count($activities) > 0)
      {{-- Activities List --}}
      <ul role="list" class="flow-root -mb-8">
        @foreach ($activities->take($maxItems) as $activity)
          <li role="listitem">
            <div class="relative pb-8">
              {{-- Timeline Line --}}
              @if (! $loop->last)
                <span
                  class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-otl-divider"
                  aria-hidden="true"
                ></span>
              @endif

              <div class="relative flex items-start space-x-3">
                {{-- Activity Icon --}}
                <div class="relative flex-shrink-0">
                  @php
                    // Icon container: ensure consistent size, contrast and focusable when action exists
                    $iconSizeClass = 'h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-bg-white dark:ring-bg-dialog';
                    $activityType = $activity['type'] ?? 'info';
                    $iconBg = match ($activityType) {
                      'success' => 'bg-success-500',
                      'warning' => 'bg-warning-500',
                      'danger' => 'bg-danger-500',
                      'info' => 'bg-primary-500',
                      default => 'bg-gray-500',
                    };
                  @endphp

                  <span
                    class="{{ $iconSizeClass }} {{ $iconBg }}"
                    aria-hidden="true"
                  >
                    @if (isset($activity['icon']))
                      {{-- Allow custom icon (ensure it follows MYDS 20x20 1.5 stroke) --}}
                      {!! $activity['icon'] !!}
                    @else
                      {{-- Default MYDS-style 20x20 icons (stroke 1.5) --}}

                      @switch($activityType)
                        @case('success')
                          <svg
                            class="h-5 w-5 text-white"
                            viewBox="0 0 20 20"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            xmlns="http://www.w3.org/2000/svg"
                            focusable="false"
                            aria-hidden="true"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M5 10l3 3 7-7"
                            />
                          </svg>

                          @break
                        @case('warning')
                          <svg
                            class="h-5 w-5 text-white"
                            viewBox="0 0 20 20"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            xmlns="http://www.w3.org/2000/svg"
                            focusable="false"
                            aria-hidden="true"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M10 3.5L2.4 17h15.2L10 3.5zM10 9v2m0 2h.01"
                            />
                          </svg>

                          @break
                        @case('danger')
                          <svg
                            class="h-5 w-5 text-white"
                            viewBox="0 0 20 20"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            xmlns="http://www.w3.org/2000/svg"
                            focusable="false"
                            aria-hidden="true"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M6 6l8 8M6 14L14 6"
                            />
                          </svg>

                          @break
                        @default
                          <svg
                            class="h-5 w-5 text-white"
                            viewBox="0 0 20 20"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            xmlns="http://www.w3.org/2000/svg"
                            focusable="false"
                            aria-hidden="true"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M10 2a8 8 0 100 16 8 8 0 000-16zM11 7h-2v5h2V7zM11 14h-2v1h2v-1z"
                            />
                          </svg>
                      @endswitch
                    @endif
                  </span>
                </div>

                {{-- Activity Content --}}
                <div class="min-w-0 flex-1">
                  <div>
                    <p class="text-sm font-medium text-txt-black-900">
                      {{ $activity['title'] ?? 'Aktiviti' }}
                    </p>

                    @if (isset($activity['description']))
                      <p class="mt-1 text-sm text-txt-black-700">
                        {{ $activity['description'] }}
                      </p>
                    @endif

                    {{-- Activity Meta --}}
                    <div
                      class="mt-2 flex flex-wrap items-center gap-2 text-sm text-txt-black-500"
                    >
                      @if (isset($activity['user']))
                        <span aria-label="Pengguna">
                          {{ $activity['user'] }}
                        </span>
                        <span aria-hidden="true">&middot;</span>
                      @endif

                      @if (isset($activity['timestamp']))
                        <time
                          datetime="{{ is_object($activity['timestamp']) && method_exists($activity['timestamp'], 'toIso8601String') ? $activity['timestamp']->toIso8601String() : $activity['timestamp'] }}"
                          title="{{ is_object($activity['timestamp']) && method_exists($activity['timestamp'], 'toDayDateTimeString') ? $activity['timestamp']->toDayDateTimeString() : $activity['timestamp'] }}"
                        >
                          {{ is_object($activity['timestamp']) && method_exists($activity['timestamp'], 'diffForHumans') ? $activity['timestamp']->diffForHumans() : $activity['timestamp'] }}
                        </time>
                      @endif

                      @if (isset($activity['status']))
                        <span aria-hidden="true">&middot;</span>
                        {{-- Non-colour indicator: badge with text + visually-hidden status label for screen readers --}}
                        <x-myds.badge
                          :variant="match($activity['status']) {
                            'approved', 'completed' => 'success',
                            'pending', 'in_progress' => 'warning',
                            'rejected', 'cancelled' => 'danger',
                            default => 'gray'
                          }"
                          size="sm"
                        >
                          {{ ucfirst(str_replace('_', ' ', $activity['status'])) }}
                        </x-myds.badge>
                      @endif
                    </div>

                    {{-- Action Link --}}
                    @if (isset($activity['url']))
                      <div class="mt-2">
                        <a
                          href="{{ $activity['url'] }}"
                          class="text-sm font-medium text-txt-primary hover:text-primary-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded"
                          aria-label="{{ $activity['action_text'] ?? 'Lihat detail' }}"
                        >
                          {{ $activity['action_text'] ?? 'Lihat Detail' }}
                          <span aria-hidden="true">→</span>
                        </a>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </li>
        @endforeach
      </ul>

      {{-- View all footer (if more items exist) --}}
      @if ($showViewAll && $viewAllUrl && count($activities) > $maxItems)
        <div class="mt-4 pt-4 border-t border-otl-divider">
          <a
            href="{{ $viewAllUrl }}"
            class="text-sm font-medium text-txt-primary hover:text-primary-700 focus-visible:ring-2 focus-visible:ring-fr-primary rounded"
          >
            Lihat Semua Aktiviti
          </a>
        </div>
      @endif
    @else
      {{-- Empty State --}}
      <div class="text-center py-8">
        <div class="mx-auto h-12 w-12 text-txt-black-400" aria-hidden="true">
          <svg
            class="h-12 w-12 mx-auto text-otl-divider"
            viewBox="0 0 20 20"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 8v4l3 3M18 12a6 6 0 11-12 0 6 6 0 0112 0z"
            />
          </svg>
        </div>
        <h4 class="mt-2 text-sm font-medium text-txt-black-900">
          Tiada aktiviti
        </h4>
        <p class="mt-1 text-sm text-txt-black-500">
          Aktiviti terkini akan dipaparkan di sini.
        </p>
      </div>
    @endif

    {{-- Additional Slot Content --}}
    @if (isset($slot) && ! empty(trim($slot)))
      <div class="mt-4 pt-4 border-t border-otl-divider">
        {{ $slot }}
      </div>
    @endif
  </div>
</div>
