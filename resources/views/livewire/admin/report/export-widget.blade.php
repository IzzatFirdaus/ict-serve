<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
  <h3 class="text-lg font-semibold mb-4">{{ __('Export Reports') }}</h3>

  <!-- Report Type Selection -->
  <div class="mb-4">
    <label
      class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
    >
      {{ __('Report Type') }}
    </label>
    <select
      wire:model="reportType"
      class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
    >
      <option value="all">{{ __('Complete Dashboard Report') }}</option>
      <option value="loans">{{ __('Loan Requests Only') }}</option>
      <option value="helpdesk">{{ __('Helpdesk Tickets Only') }}</option>
      <option value="equipment">{{ __('Equipment Only') }}</option>
    </select>
  </div>

  <!-- Export Format Selection -->
  <div class="mb-4">
    <label
      class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
    >
      {{ __('Export Format') }}
    </label>
    <div class="flex gap-2">
      <button
        wire:click="$set('exportType', 'excel')"
        class="px-4 py-2 rounded-md border {{ $exportType === 'excel' ? 'bg-success-600 text-white border-success-600' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600' }}"
      >
        {{ __('Excel (.xlsx)') }}
      </button>
      <button
        wire:click="$set('exportType', 'csv')"
        class="px-4 py-2 rounded-md border {{ $exportType === 'csv' ? 'bg-primary-600 text-white border-primary-600' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600' }}"
      >
        {{ __('CSV') }}
      </button>
    </div>
  </div>

  <!-- Export Button -->
  <button
    wire:click="export"
    class="w-full px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-colors duration-200 flex items-center justify-center gap-2"
  >
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
      ></path>
    </svg>
    {{ __('Download Export') }}
  </button>

  <!-- Export Info -->
  <div class="mt-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
    <p class="text-sm text-gray-600 dark:text-gray-400">
      @if ($reportType === 'all')
        {{ __('Complete report includes all loan requests, helpdesk tickets, and equipment data.') }}
      @elseif ($reportType === 'loans')
        {{ __('Export will include loan request data with user details and status information.') }}
      @elseif ($reportType === 'helpdesk')
        {{ __('Export will include helpdesk ticket data with categories and resolution status.') }}
      @elseif ($reportType === 'equipment')
        {{ __('Export will include equipment inventory with specifications and status.') }}
      @endif
    </p>
    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
      {{ __('Export format: ') }}{{ strtoupper($exportType) }}
    </p>
  </div>
</div>
