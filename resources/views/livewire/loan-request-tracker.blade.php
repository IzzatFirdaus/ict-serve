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
    <button wire:click="toggleDetails" class="myds-btn-outline myds-btn-sm">
      @if ($showDetails)
        @include('components.icon', ['name' => 'chevron-up', 'class' => 'w-4 h-4 mr-1'])
        {{ __('ui.hide_details') }}
      @else
        @include('components.icon', ['name' => 'chevron-down', 'class' => 'w-4 h-4 mr-1'])
        {{ __('ui.show_details') }}
      @endif
    </button>

    <!-- Polling Controls -->
    <div class="flex items-center space-x-2">
      @if ($polling)
        <button
          wire:click="disablePolling"
          class="myds-btn-outline-danger myds-btn-sm"
          :title="__('polling.stop_auto_refresh')"
        >
          @include('components.icon', ['name' => 'pause', 'class' => 'w-4 h-4 mr-1'])
          {{ __('polling.stop_auto_refresh') }}
        </button>
      @else
        <button
          wire:click="enablePolling"
          class="myds-btn-outline-primary myds-btn-sm"
          :title="__('polling.enable_auto_refresh') . ' ' . $pollInterval"
        >
          @include('components.icon', ['name' => 'refresh', 'class' => 'w-4 h-4 mr-1'])
          {{ __('polling.enable_auto_refresh') }}
        </button>
      @endif

      <button
        wire:click="refreshStatus"
        class="myds-btn-outline myds-btn-sm"
        :title="__('polling.refresh_now')"
      >
        @include('components.icon', ['name' => 'refresh', 'class' => 'w-4 h-4'])
      </button>
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
