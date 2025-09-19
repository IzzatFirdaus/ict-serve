<div>
  <h3 class="text-lg font-semibold mb-4">
    {{ __('Helpdesk Performance Metrics') }}
  </h3>
  <div class="grid grid-cols-2 gap-4 mb-6">
    <div class="bg-warning-50 rounded-lg p-4">
      <div class="text-sm text-gray-600">{{ __('Open') }}</div>
      <div class="text-2xl font-bold text-warning-700">
        {{ $stats['open'] }}
      </div>
    </div>
    <div class="bg-blue-50 rounded-lg p-4">
      <div class="text-sm text-gray-600">{{ __('In Progress') }}</div>
      <div class="text-2xl font-bold text-blue-700">
        {{ $stats['in_progress'] }}
      </div>
    </div>
    <div class="bg-success-50 rounded-lg p-4">
      <div class="text-sm text-gray-600">{{ __('Resolved') }}</div>
      <div class="text-2xl font-bold text-success-700">
        {{ $stats['resolved'] }}
      </div>
    </div>
    <div class="bg-gray-50 rounded-lg p-4">
      <div class="text-sm text-gray-600">{{ __('Closed') }}</div>
      <div class="text-2xl font-bold text-gray-700">
        {{ $stats['closed'] }}
      </div>
    </div>
  </div>
  <h4 class="text-md font-semibold mb-2">{{ __('Monthly Trends') }}</h4>
  <table class="min-w-full bg-white rounded-lg shadow">
    <thead>
      <tr>
        <th class="px-4 py-2">{{ __('Month') }}</th>
        <th class="px-4 py-2">{{ __('Tickets') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($stats['monthly'] as $row)
        <tr>
          <td class="px-4 py-2">
            {{ $row->year }}-{{ str_pad($row->month, 2, '0', STR_PAD_LEFT) }}
          </td>
          <td class="px-4 py-2 font-bold">{{ $row->count }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
