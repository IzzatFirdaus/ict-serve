<div
  x-data="{
    showNotification: @entangle('isVisible'),
    autoHideTimeout: @entangle('autoHideTimeout'),
  }"
  x-show="showNotification"
  x-transition:enter="transition ease-out duration-300"
  x-transition:enter-start="transform -translate-y-full opacity-0"
  x-transition:enter-end="transform translate-y-0 opacity-100"
  x-transition:leave="transition ease-in duration-300"
  x-transition:leave-start="transform translate-y-0 opacity-100"
  x-transition:leave-end="transform -translate-y-full opacity-0"
  x-on:auto-hide-notification.window="setTimeout(() => $wire.hideNotification(), $event.detail.timeout)"
  class="fixed top-0 left-0 right-0 z-50"
  class="fixed top-0 left-0 right-0 z-50 myds-system-notification"
>
  @if ($currentNotification)
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div
        class="rounded-b-lg shadow-lg {{ $this->getNotificationClasses($currentNotification['type']) }}"
      >
        <div class="px-4 py-3">
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                @if ($currentNotification['type'] === 'warning')
                  <!-- Warning Triangle SVG -->
                  <svg
                    class="w-5 h-5 text-warning-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 14.5c-.77.833.192 2.5 1.732 2.5z"
                    />
                  </svg>
                @elseif ($currentNotification['type'] === 'danger')
                  <!-- X Circle SVG -->
                  <svg
                    class="w-5 h-5 text-danger-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                @elseif ($currentNotification['type'] === 'success')
                  <!-- Check Circle SVG -->
                  <svg
                    class="w-5 h-5 text-success-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                @else
                  <!-- Info Circle SVG -->
                  <svg
                    class="w-5 h-5 text-primary-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                @endif
              </div>
              <div class="ml-3">
                <h3
                  class="text-sm font-medium font-poppins {{ $this->getTitleColor($currentNotification['type']) }}"
                >
                  {{ $currentNotification['title'] }}
                </h3>
                <p
                  class="text-sm font-inter {{ $this->getMessageColor($currentNotification['type']) }}"
                >
                  {{ $currentNotification['message'] }}
                </p>
              </div>
            </div>

            <div class="flex items-center space-x-2">
              @if (isset($currentNotification['action']))
                <button
                  wire:click="executeAction"
                  class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-inter font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200"
                >
                  {{ $currentNotification['action']['label'] }}
                </button>
              @endif

              <button
                wire:click="dismissNotification"
                class="flex-shrink-0 p-1 rounded-md hover:bg-black-100 dark:hover:bg-black-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors duration-200"
                aria-label="{{ __('Tutup notifikasi / Close notification') }}"
              >
                <!-- X Close SVG -->
                <svg
                  class="w-4 h-4 {{ $this->getCloseIconColor($currentNotification['type']) }}"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  aria-hidden="true"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>

        {{-- Progress bar for auto-hide --}}
        @if (! $currentNotification['persistent'])
                <div class="h-1 bg-black-200">
            <div
              class="h-full bg-primary-600 transition-all toast-progress-track"
              x-data="{ progress: 0 }"
              x-init="setTimeout(() => (progress = 100), 100)"
              :style="`width: ${progress}%`"
            ></div>
          </div>
        @endif
      </div>
    </div>
  @endif
</div>

<script
  src="{{ asset('js/livewire/system-notification-bar.js') }}"
  defer
></script>
