{{--
  ICTServe (iServe) – Helpdesk Performance Metrics
  MYDS & MyGovEA Compliant: Grid, tokens, icon, a11y, citizen-centric, clear hierarchy
--}}

<section aria-labelledby="helpdesk-performance-title" class="bg-white shadow-card rounded-lg p-6 mb-8">
  <h3 id="helpdesk-performance-title" class="text-xl font-semibold text-txt-black-900 mb-4 flex items-center gap-2">
    {{-- MYDS headset/support icon --}}
    <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
      <path d="M3 10a7 7 0 0 1 14 0v2.5a2.5 2.5 0 0 1-2.5 2.5h-1a.5.5 0 0 1 0-1h1a1.5 1.5 0 0 0 1.5-1.5V10a6 6 0 1 0-12 0v2.5A1.5 1.5 0 0 0 5 14h1a.5.5 0 0 1 0 1H5A2.5 2.5 0 0 1 2.5 12.5V10z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      <circle cx="7" cy="16" r="1" fill="currentColor"/>
      <circle cx="13" cy="16" r="1" fill="currentColor"/>
    </svg>
    {{ __('Helpdesk Performance Metrics') }}
  </h3>

  {{-- Stats Grid: Each status card uses MYDS palette and a11y contrast --}}
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-warning-50 rounded-lg p-4 flex flex-col items-start" aria-label="{{ __('Open Tickets') }}">
      <span class="flex items-center gap-1 text-sm text-warning-700 font-medium mb-1">
        {{-- MYDS warning icon --}}
        <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20" aria-hidden="true">
          <path d="M10 3.5l7 13H3l7-13zm0 6v2m0 3h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
        {{ __('Open') }}
      </span>
      <span class="text-2xl font-bold text-warning-700">{{ $stats['open'] }}</span>
    </div>
    <div class="bg-primary-50 rounded-lg p-4 flex flex-col items-start" aria-label="{{ __('In Progress Tickets') }}">
      <span class="flex items-center gap-1 text-sm text-primary-700 font-medium mb-1">
        {{-- MYDS progress icon (clock) --}}
        <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20" aria-hidden="true">
          <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.5"/>
          <path d="M10 6v4l2 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
        {{ __('In Progress') }}
      </span>
      <span class="text-2xl font-bold text-primary-700">{{ $stats['in_progress'] }}</span>
    </div>
    <div class="bg-success-50 rounded-lg p-4 flex flex-col items-start" aria-label="{{ __('Resolved Tickets') }}">
      <span class="flex items-center gap-1 text-sm text-success-700 font-medium mb-1">
        {{-- MYDS check-circle icon --}}
        <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20" aria-hidden="true">
          <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.5"/>
          <path d="M7 10.5l2 2 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        {{ __('Resolved') }}
      </span>
      <span class="text-2xl font-bold text-success-700">{{ $stats['resolved'] }}</span>
    </div>
    <div class="bg-gray-50 rounded-lg p-4 flex flex-col items-start" aria-label="{{ __('Closed Tickets') }}">
      <span class="flex items-center gap-1 text-sm text-txt-black-700 font-medium mb-1">
        {{-- MYDS close icon --}}
        <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20" aria-hidden="true">
          <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.5"/>
          <path d="M7.5 12.5l5-5m-5 0l5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
        {{ __('Closed') }}
      </span>
      <span class="text-2xl font-bold text-txt-black-700">{{ $stats['closed'] }}</span>
    </div>
  </div>

  <h4 class="text-md font-semibold text-txt-black-900 mb-2">
    {{-- MYDS trend/analytics icon --}}
    <span class="inline-flex items-center gap-1">
      <svg class="w-4 h-4 text-primary-600" fill="none" viewBox="0 0 20 20" aria-hidden="true">
        <path d="M3 12.5l4-4 3 3 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        <circle cx="3" cy="12.5" r="1" fill="currentColor"/>
        <circle cx="7" cy="8.5" r="1" fill="currentColor"/>
        <circle cx="10" cy="11.5" r="1" fill="currentColor"/>
        <circle cx="15" cy="6.5" r="1" fill="currentColor"/>
      </svg>
      {{ __('Monthly Trends') }}
    </span>
  </h4>

  <div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded-lg" role="table" aria-describedby="helpdesk-performance-table-caption">
      <caption id="helpdesk-performance-table-caption" class="sr-only">
        Historical monthly ticket volume for ICTServe helpdesk
      </caption>
      <thead class="bg-washed border-b otl-divider">
        <tr>
          <th class="px-4 py-2 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wide">{{ __('Month') }}</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wide">{{ __('Tickets') }}</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($stats['monthly'] as $row)
          <tr class="hover:bg-primary-50 focus-within:bg-primary-50 transition">
            <td class="px-4 py-2 text-sm text-txt-black-900 font-medium" scope="row">
              {{ $row->year }}-{{ str_pad($row->month, 2, '0', STR_PAD_LEFT) }}
            </td>
            <td class="px-4 py-2 text-sm font-semibold text-txt-black-700">
              {{ $row->count }}
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="2" class="px-4 py-8 text-center text-txt-black-500">
              {{ __('No monthly trend data available.') }}
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>
