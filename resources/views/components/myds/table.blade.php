@props([
    'headers' => [],
    'rows' => [],
    'striped' => true,
    'hover' => true,
    'bordered' => true,
])

@php
    $tableClasses = 'min-w-full';
    $tbodyClasses = $striped ? 'divide-y divide-otl-divider' : '';
    $tableContainerClasses = $bordered ? 'border border-otl-gray-200 rounded-[var(--radius-l)]' : '';
@endphp

<div class="overflow-hidden {{ $tableContainerClasses }}">
    <div class="overflow-x-auto">
        <table class="{{ $tableClasses }}" {{ $attributes }}>
            @if(count($headers) > 0)
                <thead class="bg-gray-50">
                    <tr>
                        @foreach($headers as $header)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wider">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
            @endif

            <tbody class="bg-white {{ $tbodyClasses }}">
                @if(count($rows) > 0)
                    @foreach($rows as $rowIndex => $row)
                        <tr class="{{ $striped && $rowIndex % 2 === 1 ? 'bg-gray-50' : '' }} {{ $hover ? 'hover:bg-gray-100 transition-colors' : '' }}">
                            @foreach($row as $cell)
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-txt-black-900">
                                    {{ $cell }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @else
                    {{ $slot }}
                @endif
            </tbody>
        </table>
    </div>
</div>
