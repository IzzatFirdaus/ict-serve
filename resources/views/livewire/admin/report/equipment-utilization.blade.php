{{--
  ICTServe (iServe) – Equipment Utilization by Category
  MYDS & MyGovEA Compliant: Follows grid, tokens, icon, A11y, citizen-centricity
--}}

<section aria-labelledby="equipment-utilization-title" class="bg-white shadow-card rounded-lg p-6 mb-8">
  <h3 id="equipment-utilization-title" class="text-xl font-semibold text-txt-black-900 mb-4">
    <span class="inline-flex items-center gap-2">
      {{-- Icon: Desktop/Laptop (MYDS style, 20x20, 1.5px stroke) --}}
      <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
        <rect x="2.5" y="4" width="15" height="9" rx="2" stroke="currentColor" stroke-width="1.5"/>
        <path d="M6 16h8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
      </svg>
      Equipment Utilization by Category
    </span>
  </h3>

  <div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded-lg" role="table" aria-describedby="equipment-utilization-caption">
      <caption id="equipment-utilization-caption" class="sr-only">
        Utilization summary of ICT equipment by category, including total, available, and loaned counts.
      </caption>
      <thead class="bg-washed border-b otl-divider">
        <tr>
          <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wide">
            Category
          </th>
          <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-txt-black-500 uppercase tracking-wide">
            Total
          </th>
          <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-txt-black-500 uppercase tracking-wide">
            Available
          </th>
          <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-txt-black-500 uppercase tracking-wide">
            Loaned
          </th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($stats as $row)
          <tr class="hover:bg-gray-50 focus-within:bg-primary-50 transition">
            <td class="px-4 py-2 text-sm text-txt-black-900 font-medium" scope="row">
              {{ $row->category->name ?? '-' }}
            </td>
            <td class="px-4 py-2 text-center text-sm text-txt-black-700">
              {{ $row->total }}
            </td>
            <td class="px-4 py-2 text-center text-sm font-semibold">
              <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 bg-success-50 text-success-700">
                {{-- MYDS check-circle icon --}}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                  <circle cx="10" cy="10" r="9" stroke="currentColor" stroke-width="1.5" fill="none"/>
                  <path d="M6.5 10.5l2 2 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{ $row->available }}
              </span>
            </td>
            <td class="px-4 py-2 text-center text-sm font-semibold">
              <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 bg-danger-50 text-danger-700">
                {{-- MYDS minus-circle icon --}}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                  <circle cx="10" cy="10" r="9" stroke="currentColor" stroke-width="1.5" fill="none"/>
                  <path d="M7 10h6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                {{ $row->loaned }}
              </span>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="px-4 py-8 text-center text-txt-black-500">
              No equipment data available.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>
