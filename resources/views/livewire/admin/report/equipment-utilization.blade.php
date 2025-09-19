<div>
  <h3 class="text-lg font-semibold mb-4">
    {{ __('Equipment Utilization by Category') }}
  </h3>
  <table class="min-w-full bg-white rounded-lg shadow">
    <thead>
      <tr>
        <th class="px-4 py-2 text-left">{{ __('Category') }}</th>
        <th class="px-4 py-2 text-center">{{ __('Total') }}</th>
        <th class="px-4 py-2 text-center">{{ __('Available') }}</th>
        <th class="px-4 py-2 text-center">{{ __('Loaned') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($stats as $row)
        <tr>
          <td class="px-4 py-2">{{ $row->category->name ?? '-' }}</td>
          <td class="px-4 py-2 text-center">{{ $row->total }}</td>
          <td class="px-4 py-2 text-center text-success-700 font-bold">
            {{ $row->available }}
          </td>
          <td class="px-4 py-2 text-center text-danger-700 font-bold">
            {{ $row->loaned }}
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
