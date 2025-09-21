<div class="relative" x-data="{ open: @entangle('showDropdown') }">
  {{-- Bell Icon Button --}}
  <x-myds.button
    type="button"
    variant="secondary"
    size="sm"
    class="relative rounded-full p-2"
    x-on:click="open = !open"
    aria-expanded="false"
    aria-haspopup="true"
    :aria-label="__('Buka notifikasi / View notifications')"
  >
    <x-myds.icon name="bell" class="w-5 h-5" aria-hidden="true" />

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
    role="menu"
    aria-orientation="vertical"
    tabindex="-1"
    aria-label="Notifikasi / Notifications dropdown panel"
    class="absolute right-0 z-10 mt-2 w-80 origin-top-right rounded-lg bg-white dark:bg-dialog border border-divider shadow-lg focus:outline-none ring-2 ring-primary-300 focus:ring-4 focus:ring-primary-300"
    style="min-width:20rem;"
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
                    <x-myds.icon name="alert-triangle" class="w-4 h-4 text-warning-600 dark:text-warning-400" aria-hidden="true" />
                    @break
                  @case('ticket_resolved')
                  @case('loan_approved')
                    <x-myds.icon name="check-circle" class="w-4 h-4 text-success-600 dark:text-success-400" aria-hidden="true" />
                    @break
                  @case('loan_requested')
                    <x-myds.icon name="document" class="w-4 h-4 text-primary-600 dark:text-primary-400" aria-hidden="true" />
                    @break
                  @case('equipment_due')
                  @case('equipment_overdue')
                    <x-myds.icon name="clock" class="w-4 h-4 text-warning-600 dark:text-warning-400" aria-hidden="true" />
                    @break
                  @default
                    <x-myds.icon name="info" class="w-4 h-4 text-primary-600 dark:text-primary-400" aria-hidden="true" />
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
          <x-myds.icon name="bell" class="mx-auto h-12 w-12 text-black-400 dark:text-black-500" aria-hidden="true" />
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
