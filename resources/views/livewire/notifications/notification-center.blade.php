<div class="container mx-auto px-4 py-6">
  {{-- Flash Messages --}}
  @if (session()->has('success'))
    <x-myds.callout variant="success" class="mb-6">
      {{ session('success') }}
    </x-myds.callout>
  @endif

  @if (session()->has('error'))
    <x-myds.callout variant="danger" class="mb-6">
      {{ session('error') }}
    </x-myds.callout>
  @endif

  @if (session()->has('info'))
    <x-myds.callout variant="info" class="mb-6">
      {{ session('info') }}
    </x-myds.callout>
  @endif

  {{-- Header --}}
  <div class="mb-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold font-poppins text-black-900">
          Pusat Notifikasi
        </h1>
        <p class="text-sm text-black-500 font-inter mt-1">
          Kelola semua notifikasi dan maklumat penting anda
        </p>
      </div>
      <div class="flex items-center space-x-3">
        <span
          class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-700"
        >
          {{ $unreadCount }} belum dibaca
        </span>
        @if ($unreadCount > 0)
          <button
            wire:click="openMarkAllModal"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-inter font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200"
          >
            <!-- Check Circle SVG -->
            <svg
              class="w-4 h-4 mr-2"
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
            Tandai Semua Dibaca
          </button>
        @endif
      </div>
    </div>
  </div>

  {{-- Statistics Cards --}}
  <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-6">
    <div class="bg-white border border-divider rounded-lg p-4">
      <div class="text-center">
        <div class="text-2xl font-semibold text-black-900 font-poppins">
          {{ $stats['total'] }}
        </div>
        <div class="text-xs text-black-500 font-inter">Jumlah</div>
      </div>
    </div>
    <div class="bg-white border border-divider rounded-lg p-4">
      <div class="text-center">
        <div class="text-2xl font-semibold text-primary-600 font-poppins">
          {{ $stats['unread'] }}
        </div>
        <div class="text-xs text-black-500 font-inter">Belum Dibaca</div>
      </div>
    </div>
    <div class="bg-white border border-divider rounded-lg p-4">
      <div class="text-center">
        <div class="text-2xl font-semibold text-warning-600 font-poppins">
          {{ $stats['tickets'] }}
        </div>
        <div class="text-xs text-black-500 font-inter">Tiket Helpdesk</div>
      </div>
    </div>
    <div class="bg-white border border-divider rounded-lg p-4">
      <div class="text-center">
        <div class="text-2xl font-semibold text-success-600 font-poppins">
          {{ $stats['loans'] }}
        </div>
        <div class="text-xs text-black-500 font-inter">Pinjaman</div>
      </div>
    </div>
    <div class="bg-white border border-divider rounded-lg p-4">
      <div class="text-center">
        <div class="text-2xl font-semibold text-secondary-600 font-poppins">
          {{ $stats['system'] }}
        </div>
        <div class="text-xs text-black-500 font-inter">Sistem</div>
      </div>
    </div>
    <div class="bg-white border border-divider rounded-lg p-4">
      <div class="text-center">
        <div class="text-2xl font-semibold text-danger-600 font-poppins">
          {{ $stats['urgent'] }}
        </div>
        <div class="text-xs text-black-500 font-inter">Segera</div>
      </div>
    </div>
  </div>

  {{-- Filters --}}
  <div class="bg-white border border-divider rounded-lg p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      {{-- Status Filter --}}
      <div>
        <label
          class="block text-sm font-medium text-black-700 dark:text-black-300 font-inter mb-2"
        >
          Status
        </label>
        <select
          wire:model.live="filter"
          class="block w-full px-3 py-2 border border-divider rounded-md shadow-sm font-inter text-sm text-black-900 dark:text-white bg-white dark:bg-dialog focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
        >
          @foreach ($this->getFilterOptions() as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
          @endforeach
        </select>
      </div>

      {{-- Category Filter --}}
      <div>
        <label
          class="block text-sm font-medium text-black-700 dark:text-black-300 font-inter mb-2"
        >
          Kategori
        </label>
        <select
          wire:model.live="category"
          class="block w-full px-3 py-2 border border-divider rounded-md shadow-sm font-inter text-sm text-black-900 dark:text-white bg-white dark:bg-dialog focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
        >
          @foreach ($this->getCategoryOptions() as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
          @endforeach
        </select>
      </div>

      {{-- Priority Filter --}}
      <div>
        <label
          class="block text-sm font-medium text-black-700 dark:text-black-300 font-inter mb-2"
        >
          Keutamaan
        </label>
        <select
          wire:model.live="priority"
          class="block w-full px-3 py-2 border border-divider rounded-md shadow-sm font-inter text-sm text-black-900 dark:text-white bg-white dark:bg-dialog focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
        >
          @foreach ($this->getPriorityOptions() as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
          @endforeach
        </select>
      </div>

      {{-- Clear Read Notifications --}}
      <div class="flex items-end">
        <button
          wire:click="clearAllRead"
          wire:confirm="Adakah anda pasti ingin menghapus semua notifikasi yang telah dibaca?"
          class="w-full inline-flex items-center justify-center px-4 py-2 border border-divider text-sm font-inter font-medium rounded-md text-black-700 dark:text-black-300 bg-white dark:bg-dialog hover:bg-washed dark:hover:bg-black-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200"
        >
          <!-- Trash SVG -->
          <svg
            class="w-4 h-4 mr-2"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            aria-hidden="true"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
            />
          </svg>
          Hapus Yang Dibaca
        </button>
      </div>
    </div>
  </div>

  {{-- Notifications List --}}
  <div class="bg-white border border-divider rounded-lg overflow-hidden">
    @if ($notifications->count() > 0)
      <div class="divide-y divide-divider">
        @foreach ($notifications as $notification)
          <div
            class="px-6 py-4 hover:bg-washed transition-colors duration-150 {{ ! $notification->is_read ? 'bg-primary-50' : '' }}"
            wire:key="notification-{{ $notification->id }}"
          >
            <div class="flex items-start space-x-4">
              {{-- Icon --}}
              <div class="flex-shrink-0">
                @php
                  $iconConfig = match ($notification->type) {
                    'ticket_created', 'ticket_updated' => ['icon' => 'warning', 'color' => 'warning'],
                    'ticket_resolved', 'loan_approved' => ['icon' => 'check-circle', 'color' => 'success'],
                    'loan_requested' => ['icon' => 'document', 'color' => 'primary'],
                    'equipment_due', 'equipment_overdue' => ['icon' => 'clock', 'color' => 'danger'],
                    default => ['icon' => 'info', 'color' => 'secondary'],
                  };
                @endphp

                <div
                  class="w-10 h-10 rounded-full bg-{{ $iconConfig['color'] }}-100 dark:bg-{{ $iconConfig['color'] }}-900 flex items-center justify-center"
                >
                  @switch($iconConfig['icon'])
                    @case('warning')
                      <!-- Warning Triangle SVG -->
                      <svg
                        class="w-5 h-5 text-{{ $iconConfig['color'] }}-600 dark:text-{{ $iconConfig['color'] }}-400"
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
                    @case('check-circle')
                      <!-- Check Circle SVG -->
                      <svg
                        class="w-5 h-5 text-{{ $iconConfig['color'] }}-600 dark:text-{{ $iconConfig['color'] }}-400"
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
                    @case('document')
                      <!-- Document SVG -->
                      <svg
                        class="w-5 h-5 text-{{ $iconConfig['color'] }}-600 dark:text-{{ $iconConfig['color'] }}-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                      </svg>

                      @break
                    @case('clock')
                      <!-- Clock SVG -->
                      <svg
                        class="w-5 h-5 text-{{ $iconConfig['color'] }}-600 dark:text-{{ $iconConfig['color'] }}-400"
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
                        class="w-5 h-5 text-{{ $iconConfig['color'] }}-600 dark:text-{{ $iconConfig['color'] }}-400"
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
                <div class="flex items-center justify-between">
                  <h3
                    class="text-sm font-medium text-black-900 font-inter truncate"
                  >
                    {{ $notification->title }}
                  </h3>
                  <div class="flex items-center space-x-2">
                    {{-- Priority Badge --}}
                    <span
                      class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border {{ $this->getPriorityColor($notification->priority) }}"
                    >
                      {{ ucfirst(is_object($notification->priority) && method_exists($notification->priority, 'value') ? (string) $notification->priority->value : (string) $notification->priority) }}
                    </span>

                    {{-- Category Badge --}}
                    <span
                      class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border {{ $this->getCategoryColor($notification->category) }}"
                    >
                      {{ ucfirst(is_object($notification->category) && method_exists($notification->category, 'value') ? (string) $notification->category->value : (string) $notification->category) }}
                    </span>
                  </div>
                </div>

                <p class="mt-1 text-sm text-black-600 font-inter">
                  {{ $notification->message }}
                </p>

                <div class="mt-2 flex items-center justify-between">
                  <span class="text-xs text-black-500 font-inter">
                    {{ $notification->getTimeAgo() }}
                  </span>

                  <div class="flex items-center space-x-2">
                    {{-- Action Button --}}
                    @if ($notification->action_url)
                      <button
                        onclick="window.location.href='{{ $notification->action_url }}'; @this.markNotificationAsRead({{ $notification->id }})"
                        class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-inter font-medium rounded text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200"
                      >
                        <!-- Eye SVG -->
                        <svg
                          class="w-3 h-3 mr-1"
                          fill="none"
                          stroke="currentColor"
                          viewBox="0 0 24 24"
                          aria-hidden="true"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                          />
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                          />
                        </svg>
                        Lihat
                      </button>
                    @endif

                    {{-- Mark as Read/Unread --}}
                    @if (! $notification->is_read)
                      <button
                        wire:click="markNotificationAsRead({{ $notification->id }})"
                        class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-inter font-medium rounded text-white bg-success-600 hover:bg-success-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-success-500 transition-colors duration-200"
                      >
                        <!-- Check SVG -->
                        <svg
                          class="w-3 h-3 mr-1"
                          fill="none"
                          stroke="currentColor"
                          viewBox="0 0 24 24"
                          aria-hidden="true"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                          />
                        </svg>
                        Tandai Dibaca
                      </button>
                    @endif

                    {{-- Delete --}}
                    <button
                      wire:click="deleteNotification({{ $notification->id }})"
                      wire:confirm="Adakah anda pasti ingin menghapus notifikasi ini?"
                      class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-inter font-medium rounded text-white bg-danger-600 hover:bg-danger-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-danger-500 transition-colors duration-200"
                    >
                      <!-- Trash SVG -->
                      <svg
                        class="w-3 h-3 mr-1"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        />
                      </svg>
                      Hapus
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Pagination --}}
      @if ($notifications->hasPages())
        <div class="px-6 py-4 border-t border-divider">
          {{ $notifications->links() }}
        </div>
      @endif
    @else
      <div class="px-6 py-12 text-center">
        <!-- Bell SVG -->
        <svg
          class="mx-auto h-12 w-12 text-black-300 dark:text-black-600 mb-4"
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
          class="text-lg font-medium text-black-900 dark:text-white font-poppins mb-2"
        >
          Tiada Notifikasi
        </h3>
        <p class="text-black-500 dark:text-black-400 font-inter">
          Anda tidak mempunyai notifikasi mengikut penapis yang dipilih.
        </p>
      </div>
    @endif
  </div>

  {{-- Mark All Modal --}}
  @if ($showMarkAllModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
      <div
        class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0"
      >
        <div
          class="fixed inset-0 transition-opacity bg-black-500 bg-opacity-75"
          wire:click="closeMarkAllModal"
        ></div>

        <div
          class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6"
        >
          <div>
            <div
              class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-primary-100 dark:bg-primary-900"
            >
              <!-- Check Circle SVG -->
              <svg
                class="w-6 h-6 text-primary-600 dark:text-primary-400"
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
            </div>
            <div class="mt-3 text-center sm:mt-5">
              <h3
                class="text-lg leading-6 font-medium text-black-900 dark:text-white font-poppins"
              >
                Tandai Semua Sebagai Dibaca
              </h3>
              <div class="mt-2">
                <p
                  class="text-sm text-black-500 dark:text-black-400 font-inter"
                >
                  Adakah anda pasti ingin menandai semua {{ $unreadCount }}
                  notifikasi sebagai telah dibaca?
                </p>
              </div>
            </div>
          </div>

          <div
            class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense"
          >
            <button
              type="button"
              wire:click="markAllAsRead"
              class="w-full inline-flex justify-center px-4 py-2 border border-transparent text-sm font-inter font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:col-start-2 transition-colors duration-200"
            >
              Ya, Tandai Semua
            </button>
            <button
              type="button"
              wire:click="closeMarkAllModal"
              class="mt-3 w-full inline-flex justify-center px-4 py-2 border border-divider text-sm font-inter font-medium rounded-md text-black-700 dark:text-black-300 bg-white dark:bg-dialog hover:bg-washed dark:hover:bg-black-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:col-start-1 transition-colors duration-200"
            >
              Batal
            </button>
          </div>
        </div>
      </div>
    </div>
  @endif

  {{-- Loading State --}}
  <div
    wire:loading
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
  >
    <div class="bg-white p-6 rounded-lg shadow-lg">
      <div class="flex items-center space-x-3">
        <div
          class="animate-spin rounded-full h-5 w-5 border-b-2 border-primary-600"
        ></div>
        <span class="text-sm text-black-700 font-inter">Memproses...</span>
      </div>
    </div>
  </div>
</div>
