<div>
    <h3 class="text-lg font-semibold mb-4">{{ __('Loan Request Metrics & Trends') }}</h3>
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="bg-primary-50 rounded-lg p-4">
            <div class="text-sm text-gray-600">{{ __('Total Requests') }}</div>
            <div class="text-2xl font-bold text-primary-700">{{ $metrics['total'] }}</div>
        </div>
        <div class="bg-success-50 rounded-lg p-4">
            <div class="text-sm text-gray-600">{{ __('Approved') }}</div>
            <div class="text-2xl font-bold text-success-700">{{ $metrics['approved'] }}</div>
        </div>
        <div class="bg-warning-50 rounded-lg p-4">
            <div class="text-sm text-gray-600">{{ __('Pending') }}</div>
            <div class="text-2xl font-bold text-warning-700">{{ $metrics['pending'] }}</div>
        </div>
        <div class="bg-danger-50 rounded-lg p-4">
            <div class="text-sm text-gray-600">{{ __('Rejected') }}</div>
            <div class="text-2xl font-bold text-danger-700">{{ $metrics['rejected'] }}</div>
        </div>
    </div>
    <h4 class="text-md font-semibold mb-2">{{ __('Monthly Trends') }}</h4>
    <table class="min-w-full bg-white rounded-lg shadow">
        <thead>
            <tr>
                <th class="px-4 py-2">{{ __('Month') }}</th>
                <th class="px-4 py-2">{{ __('Requests') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($metrics['monthly'] as $row)
                <tr>
                    <td class="px-4 py-2">{{ $row->year }}-{{ str_pad($row->month, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-4 py-2 font-bold">{{ $row->count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
