<div
  class="loan-request-tracker"
  @if($polling) wire:poll.{{ $pollInterval }}="refreshStatus" @endif
>
  <!-- Enhanced Status Display -->
  <x-loan-status-tracker
    :loan-request="$loanRequest"
    :show-progress="true"
    :show-timeline="$showDetails"
    :polling="$polling"
    :poll-interval="$pollInterval"
  />

  <p class="sr-only">{{ $loanRequest->purpose }}</p>

  <!-- Toggle Details Button -->
  <div class="mt-6 flex items-center justify-between">
    <x-myds.button wire:click="toggleDetails" variant="outline" size="sm">
      @if ($showDetails)
        <x-myds.icon
          name="chevron-up"
          class="w-4 h-4 mr-1"
          aria-hidden="true"
        />
        {{ __('ui.hide_details') }}
      @else
        <x-myds.icon
          name="chevron-down"
          class="w-4 h-4 mr-1"
          aria-hidden="true"
        />
        {{ __('ui.show_details') }}
      @endif
    </x-myds.button>

    <!-- Polling Controls -->
    <div class="flex items-center space-x-2">
      @if ($polling)
        <x-myds.button
          wire:click="disablePolling"
          variant="danger-outline"
          size="sm"
          :title="__('polling.stop_auto_refresh')"
        >
          <x-myds.icon name="pause" class="w-4 h-4 mr-1" aria-hidden="true" />
          {{ __('polling.stop_auto_refresh') }}
        </x-myds.button>
      @else
        <x-myds.button
          wire:click="enablePolling"
          variant="primary-outline"
          size="sm"
          :title="__('polling.enable_auto_refresh') . ' ' . $pollInterval"
        >
          <x-myds.icon name="refresh" class="w-4 h-4 mr-1" aria-hidden="true" />
          {{ __('polling.enable_auto_refresh') }}
        </x-myds.button>
      @endif

      <x-myds.button
        wire:click="refreshStatus"
        variant="outline"
        size="sm"
        :title="__('polling.refresh_now')"
      >
        <x-myds.icon name="refresh" class="w-4 h-4" aria-hidden="true" />
      </x-myds.button>
    </div>
  </div>

  <!-- Detailed View -->
  @if ($showDetails)
    <div
      class="mt-6"
      x-data
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0 transform translate-y-4"
      x-transition:enter-end="opacity-100 transform translate-y-0"
    >
      <x-loan-detail-view :loan-request="$loanRequest" />
    </div>
  @endif

  <!-- Real-time Notifications -->
  <div
    x-data="{
      show: false,
      message: '',
      showNotification(message) {
        this.message = message
        this.show = true
        setTimeout(() => {
          this.show = false
        }, 3000)
      },
    }"
    @status-refreshed.window="if ($event.detail.loanRequestId === {{ $loanRequest->id }}) showNotification('{{ __('notifications.status_updated') }}')"
    @polling-enabled.window="showNotification('{{ __('notifications.polling_enabled') }}')"
    @polling-disabled.window="showNotification('{{ __('notifications.polling_disabled') }}')"
  >
    <div
      x-show="show"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0 transform translate-y-2"
      x-transition:enter-end="opacity-100 transform translate-y-0"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100 transform translate-y-0"
      x-transition:leave-end="opacity-0 transform translate-y-2"
      class="fixed bottom-4 right-4 bg-bg-primary-600 text-white px-4 py-2 rounded-lg shadow-lg z-50"
    >
      <p class="text-sm font-medium" x-text="message"></p>
    </div>
  </div>
</div>
