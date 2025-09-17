{{--
  ICTServe (iServe) – Loan Request Metrics & Trends
  MYDS & MyGovEA Compliant: Grid, tokens, icon, a11y, citizen-centric, clear hierarchy
--}}

<section aria-labelledby="loan-metrics-title" class="bg-white shadow-card rounded-lg p-6 mb-8">
  <h3 id="loan-metrics-title" class="text-xl font-semibold text-txt-black-900 mb-4 flex items-center gap-2">
    {{-- MYDS briefcase icon --}}
    <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
      <rect x="4" y="6" width="12" height="9" rx="2" stroke="currentColor" stroke-width="1.5"/>
      <path d="M7 6V5a3 3 0 1 1 6 0v1" stroke="currentColor" stroke-width="1.5"/>
    </svg>
    {{ __('Loan Request Metrics & Trends') }}
  </h3>

  {{-- Stats Grid: Each card uses MYDS palette and a11y contrast --}}
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-primary-50 rounded-lg p-4 flex flex-col items-start" aria-label="{{ __('Total Requests') }}">
      <span class="flex items-center gap-1 text-sm text-primary-700 font-medium mb-1">
        {{-- MYDS list/bullet icon --}}
        <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20" aria-hidden="true">
          <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.5"/>
          <circle cx="10" cy="10" r="2" fill="currentColor"/>
        </svg>
        {{ __('Total Requests') }}
      </span>
      <span class="text-2xl font-bold text-primary-700">{{ $metrics['total'] }}</span>
    </div>
    <div class="bg-success-50 rounded-lg p-4 flex flex-col items-start" aria-label="{{ __('Approved Requests') }}">
      <span class="flex items-center gap-1 text-sm text-success-700 font-medium mb-1">
        {{-- MYDS check-circle icon --}}
        <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20" aria-hidden="true">
          <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.5"/>
          <path d="M7 10.5l2 2 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        {{ __('Approved') }}
      </span>
      <span class="text-2xl font-bold text-success-700">{{ $metrics['approved'] }}</span>
    </div>
    <div class="bg-warning-50 rounded-lg p-4 flex flex-col items-start" aria-label="{{ __('Pending Requests') }}">
      <span class="flex items-center gap-1 text-sm text-warning-700 font-medium mb-1">
        {{-- MYDS clock icon --}}
        <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20" aria-hidden="true">
          <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.5"/>
          <path d="M10 6v4l2 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
        {{ __('Pending') }}
      </span>
      <span class="text-2xl font-bold text-warning-700">{{ $metrics['pending'] }}</span>
    </div>
    <div class="bg-danger-50 rounded-lg p-4 flex flex-col items-start" aria-label="{{ __('Rejected Requests') }}">
      <span class="flex items-center gap-1 text-sm text-danger-700 font-medium mb-1">
        {{-- MYDS close/cross icon --}}
        <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20" aria-hidden="true">
          <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.5"/>
          <path d="M7.5 12.5l5-5m-5 0l5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
        {{ __('Rejected') }}
      </span>
      <span class="text-2xl font-bold text-danger-700">{{ $metrics['rejected'] }}</span>
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
    <table class="min-w-full bg-white rounded-lg" role="table" aria-describedby="loan-metrics-table-caption">
      <caption id="loan-metrics-table-caption" class="sr-only">
        Historical monthly loan requests for ICT equipment
      </caption>
      <thead class="bg-washed border-b otl-divider">
        <tr>
          <th class="px-4 py-2 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wide">{{ __('Month') }}</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wide">{{ __('Requests') }}</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($metrics['monthly'] as $row)
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
