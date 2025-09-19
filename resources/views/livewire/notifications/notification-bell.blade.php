<div class="relative" x-data="{ open: @entangle('showDropdown') }">
  {{-- Bell Icon Button --}}
  <button
    @click="open = !open"
    type="button"
    class="relative rounded-full bg-white dark:bg-dialog p-2 text-black-500 dark:text-black-400 hover:text-primary-600 dark:hover:text-primary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 border border-divider"
    aria-expanded="false"
    aria-haspopup="true"
    aria-label="{{ __('Buka notifikasi / View notifications') }}"
  >
    <!-- Bell Icon SVG -->
    <svg
      class="w-5 h-5"
      fill="none"
      stroke="currentColor"
      viewBox="0 0 24 24"
      aria-hidden="true"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M15 17h5l-3-3V9A6 6 0 1 0 6 9v5l-3 3h5a3 3 0 1 0 6 0Z"
      />
    </svg>

    {{-- Notification Badge --}}
    @if ($unreadCount > 0)
      <span
        class="absolute -top-1 -right-1 h-5 w-5 rounded-full bg-danger-600 text-xs font-medium text-white font-inter flex items-center justify-center ring-2 ring-white dark:ring-dialog"
      >
        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
      </span>
    @endif
  </button>

  {{-- Dropdown Panel --}}
  <div
    x-show="open"
    x-transition:enter="transition ease-out duration-100"
    x-transition:enter-start="transform opacity-0 scale-95"
    x-transition:enter-end="transform opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-75"
    x-transition:leave-start="transform opacity-100 scale-100"
    x-transition:leave-end="transform opacity-0 scale-95"
    @click.outside="open = false"
    class="absolute right-0 z-10 mt-2 w-80 origin-top-right rounded-lg bg-white dark:bg-dialog border border-divider shadow-lg focus:outline-none"
    role="menu"
    aria-orientation="vertical"
    class="absolute right-0 z-10 mt-2 w-80 origin-top-right rounded-lg bg-white dark:bg-dialog border border-divider shadow-lg focus:outline-none myds-dropdown-panel"
  >
    {{-- Header --}}
    <div class="px-4 py-3 border-b border-divider">
      <div class="flex items-center justify-between">
        <h3
          class="font-poppins text-sm font-semibold text-black-900 dark:text-white"
        >
          {{ __('Notifikasi / Notifications') }}
        </h3>
        <div class="flex items-center space-x-2">
          @if ($unreadCount > 0)
            <button
              wire:click="markAllAsRead"
              class="font-inter text-xs text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium"
            >
              {{ __('Tandai Semua / Mark All') }}
            </button>
          @endif

          <a
            href="{{ route('notifications.index') }}"
            class="font-inter text-xs text-black-500 dark:text-black-400 hover:text-black-700 dark:hover:text-black-300 font-medium"
            @click="open = false"
          >
            {{ __('Lihat Semua / View All') }}
          </a>
        </div>
      </div>
      @if ($unreadCount > 0)
        <p class="font-inter text-xs text-black-500 dark:text-black-400 mt-1">
          {{ $unreadCount }}
          {{ __('notifikasi belum dibaca / unread notifications') }}
        </p>
      @endif
    </div>

    {{-- Notifications List --}}
    <div class="max-h-96 overflow-y-auto">
      @forelse ($recentNotifications as $notification)
        <div
          class="px-4 py-3 hover:bg-washed dark:hover:bg-black-100 border-b border-divider last:border-b-0 {{ ! $notification->is_read ? 'bg-primary-50 dark:bg-primary-950' : '' }}"
          wire:key="bell-notification-{{ $notification->id }}"
        >
          <div class="flex items-start space-x-3">
            {{-- Icon --}}
            <div class="flex-shrink-0">
              <div
                class="w-8 h-8 rounded-full bg-{{ $notification->color ?? 'primary' }}-100 dark:bg-{{ $notification->color ?? 'primary' }}-900 flex items-center justify-center"
              >
                @switch($notification->type)
                  @case('ticket_created')
                  @case('ticket_updated')
                    <!-- Warning Triangle SVG -->
                    <svg
                      class="w-4 h-4 text-warning-600 dark:text-warning-400"
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

                    @break
                  @case('ticket_resolved')
                  @case('loan_approved')
                    <!-- Check Circle SVG -->
                    <svg
                      class="w-4 h-4 text-success-600 dark:text-success-400"
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

                    @break
                  @case('loan_requested')
                    <!-- Clipboard Document List SVG -->
                    <svg
                      class="w-4 h-4 text-primary-600 dark:text-primary-400"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                      aria-hidden="true"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                      />
                    </svg>

                    @break
                  @case('equipment_due')
                  @case('equipment_overdue')
                    <!-- Clock SVG -->
                    <svg
                      class="w-4 h-4 text-warning-600 dark:text-warning-400"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                      aria-hidden="true"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>

                    @break
                  @default
                    <!-- Info Circle SVG -->
                    <svg
                      class="w-4 h-4 text-primary-600 dark:text-primary-400"
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
                @endswitch
              </div>
            </div>

            {{-- Content --}}
            <div class="flex-1 min-w-0">
              <p
                class="font-inter text-sm font-medium text-black-900 dark:text-white truncate"
              >
                {{ $notification->title }}
              </p>
              <p
                class="font-inter text-xs text-black-600 dark:text-black-400 mt-1 line-clamp-2"
              >
                {{ $notification->message }}
              </p>
              <div class="flex items-center justify-between mt-2">
                <span
                  class="font-inter text-xs text-black-500 dark:text-black-400"
                >
                  {{ $notification->getTimeAgo() }}
                </span>
                <div class="flex items-center space-x-2">
                  @if ($notification->action_url)
                    <a
                      href="{{ $notification->action_url }}"
                      class="font-inter text-xs text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium"
                      @click="open = false; @this.markAsRead({{ $notification->id }})"
                    >
                      {{ __('Lihat / View') }}
                    </a>
                  @endif

                  @if (! $notification->is_read)
                    <button
                      wire:click="markAsRead({{ $notification->id }})"
                      class="font-inter text-xs text-success-600 dark:text-success-400 hover:text-success-700 dark:hover:text-success-300 font-medium"
                    >
                      {{ __('Tandai / Mark') }}
                    </button>
                  @endif
                </div>
              </div>
            </div>

            {{-- Unread Indicator --}}
            @if (! $notification->is_read)
              <div class="flex-shrink-0">
                <div
                  class="w-2 h-2 bg-primary-600 dark:bg-primary-400 rounded-full"
                ></div>
              </div>
            @endif
          </div>
        </div>
      @empty
        <div class="px-4 py-8 text-center">
          <!-- Bell Icon SVG -->
          <svg
            class="mx-auto h-12 w-12 text-black-400 dark:text-black-500"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            aria-hidden="true"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M15 17h5l-3-3V9A6 6 0 1 0 6 9v5l-3 3h5a3 3 0 1 0 6 0Z"
            />
          </svg>
          <h3
            class="mt-2 font-poppins text-sm font-medium text-black-900 dark:text-white"
          >
            {{ __('Tiada Notifikasi / No Notifications') }}
          </h3>
          <p class="mt-1 font-inter text-sm text-black-500 dark:text-black-400">
            {{ __('Anda tidak mempunyai notifikasi baharu / You don\'t have any new notifications') }}
          </p>
        </div>
      @endforelse
    </div>

    {{-- Footer --}}
    @if ($recentNotifications->count() > 0)
      <div
        class="px-4 py-3 border-t border-divider bg-washed dark:bg-black-100"
      >
        <a
          href="{{ route('notifications.index') }}"
          class="block text-center font-inter text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium"
          @click="open = false"
        >
          {{ __('Lihat Semua Notifikasi / View All Notifications') }}
        </a>
      </div>
    @endif
  </div>
</div>
