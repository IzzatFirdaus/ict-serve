@props([
    'headers' => [],
    'data' => [],
    'sortable' => [],
    'searchable' => false,
    'searchPlaceholder' => 'Cari...',
    'currentSort' => null,
    'sortDirection' => 'asc',
    'emptyMessage' => 'Tiada data untuk dipaparkan',
    'showPagination' => true,
    'perPageOptions' => [10, 25, 50, 100],
    'currentPage' => 1,
    'totalPages' => 1,
    'totalRecords' => 0,
    'loading' => false,
    'selectable' => false,
    'selectedIds' => [],
    'actions' => [],
    'compact' => false,
])

<div class="bg-bg-white shadow-sm rounded-lg border border-otl-divider overflow-hidden" {{ $attributes }}>
    {{-- Table Header with Search and Actions --}}
    @if($searchable || count($actions) > 0)
        <div class="px-6 py-4 border-b border-otl-divider bg-gray-50">
            <div class="flex items-center justify-between">
                {{-- Search Bar --}}
                @if($searchable)
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-txt-black-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <x-myds.input 
                                type="text"
                                placeholder="{{ $searchPlaceholder }}"
                                class="pl-10"
                                wire:model.live.debounce.300ms="search"
                            />
                        </div>
                    </div>
                @endif

                {{-- Table Actions --}}
                @if(count($actions) > 0)
                    <div class="flex items-center space-x-3 {{ $searchable ? 'ml-6' : '' }}">
                        @foreach($actions as $action)
                            @if($action['type'] === 'button')
                                <x-myds.button 
                                    variant="{{ $action['variant'] ?? 'secondary' }}"
                                    size="{{ $action['size'] ?? 'medium' }}"
                                    wire:click="{{ $action['action'] ?? '' }}"
                                    :disabled="$action['disabled'] ?? false"
                                >
                                    @if(isset($action['icon']))
                                        <x-myds.icon name="{{ $action['icon'] }}" class="mr-2 h-4 w-4" />
                                    @endif
                                    {{ $action['label'] }}
                                </x-myds.button>
                            @elseif($action['type'] === 'dropdown')
                                <div class="relative" x-data="{ open: false }">
                                    <x-myds.button 
                                        variant="secondary"
                                        @click="open = !open"
                                        class="relative"
                                    >
                                        {{ $action['label'] }}
                                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </x-myds.button>
                                    
                                    <div 
                                        x-show="open" 
                                        @click.outside="open = false"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute right-0 z-10 mt-2 w-48 rounded-md shadow-lg bg-bg-white ring-1 ring-otl-divider ring-opacity-5"
                                    >
                                        <div class="py-1">
                                            @foreach($action['items'] as $item)
                                                <button
                                                    wire:click="{{ $item['action'] }}"
                                                    @click="open = false"
                                                    class="block w-full text-left px-4 py-2 text-sm text-txt-black-700 hover:bg-gray-100 hover:text-txt-black-900"
                                                >
                                                    @if(isset($item['icon']))
                                                        <x-myds.icon name="{{ $item['icon'] }}" class="mr-2 h-4 w-4 inline" />
                                                    @endif
                                                    {{ $item['label'] }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Table Container --}}
    <div class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-otl-divider">
                {{-- Table Head --}}
                <thead class="bg-gray-50">
                    <tr>
                        {{-- Select All Checkbox --}}
                        @if($selectable)
                            <th scope="col" class="relative w-12 px-6 sm:w-16 sm:px-8">
                                <x-myds.checkbox 
                                    wire:model.live="selectAll"
                                    class="absolute left-4 top-1/2 -mt-2 h-4 w-4 sm:left-6"
                                />
                            </th>
                        @endif

                        {{-- Column Headers --}}
                        @foreach($headers as $key => $header)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wider {{ $compact ? 'py-2' : 'py-3' }}">
                                @if(in_array($key, $sortable))
                                    <button 
                                        wire:click="sortBy('{{ $key }}')"
                                        class="group inline-flex items-center hover:text-txt-black-700"
                                    >
                                        {{ $header }}
                                        <span class="ml-2 flex-none rounded">
                                            @if($currentSort === $key)
                                                @if($sortDirection === 'asc')
                                                    <svg class="h-4 w-4 text-txt-black-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                @else
                                                    <svg class="h-4 w-4 text-txt-black-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                            @else
                                                <svg class="h-4 w-4 text-txt-black-300 group-hover:text-txt-black-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                        </span>
                                    </button>
                                @else
                                    {{ $header }}
                                @endif
                            </th>
                        @endforeach

                        {{-- Actions Column --}}
                        <th scope="col" class="relative px-6 py-3 {{ $compact ? 'py-2' : 'py-3' }}">
                            <span class="sr-only">Tindakan</span>
                        </th>
                    </tr>
                </thead>

                {{-- Table Body --}}
                <tbody class="bg-bg-white divide-y divide-otl-divider">
                    @if($loading)
                        {{-- Loading State --}}
                        @for($i = 0; $i < 5; $i++)
                            <tr>
                                @if($selectable)
                                    <td class="w-12 px-6 sm:w-16 sm:px-8">
                                        <div class="h-4 w-4 bg-gray-200 rounded animate-pulse"></div>
                                    </td>
                                @endif
                                @foreach($headers as $header)
                                    <td class="px-6 py-4 whitespace-nowrap {{ $compact ? 'py-3' : 'py-4' }}">
                                        <div class="h-4 bg-gray-200 rounded animate-pulse"></div>
                                    </td>
                                @endforeach
                                <td class="px-6 py-4 whitespace-nowrap {{ $compact ? 'py-3' : 'py-4' }}">
                                    <div class="h-8 w-20 bg-gray-200 rounded animate-pulse"></div>
                                </td>
                            </tr>
                        @endfor
                    @elseif(count($data) > 0)
                        {{-- Data Rows --}}
                        @foreach($data as $index => $row)
                            <tr class="hover:bg-gray-50 {{ in_array($row['id'] ?? $index, $selectedIds) ? 'bg-primary-50' : '' }}">
                                {{-- Select Checkbox --}}
                                @if($selectable)
                                    <td class="relative w-12 px-6 sm:w-16 sm:px-8">
                                        <x-myds.checkbox 
                                            wire:model.live="selectedIds"
                                            value="{{ $row['id'] ?? $index }}"
                                            class="absolute left-4 top-1/2 -mt-2 h-4 w-4 sm:left-6"
                                        />
                                    </td>
                                @endif

                                {{-- Data Cells --}}
                                @foreach($headers as $key => $header)
                                    <td class="px-6 py-4 whitespace-nowrap {{ $compact ? 'py-3' : 'py-4' }}">
                                        @if(isset($row[$key]))
                                            @if(is_array($row[$key]) && isset($row[$key]['type']))
                                                {{-- Special cell types --}}
                                                @if($row[$key]['type'] === 'badge')
                                                    <x-myds.badge 
                                                        variant="{{ $row[$key]['variant'] ?? 'gray' }}"
                                                        size="{{ $row[$key]['size'] ?? 'medium' }}"
                                                    >
                                                        {{ $row[$key]['text'] }}
                                                    </x-myds.badge>
                                                @elseif($row[$key]['type'] === 'link')
                                                    <a 
                                                        href="{{ $row[$key]['url'] }}"
                                                        class="text-primary-600 hover:text-primary-900 font-medium"
                                                        @if($row[$key]['external'] ?? false) target="_blank" @endif
                                                    >
                                                        {{ $row[$key]['text'] }}
                                                        @if($row[$key]['external'] ?? false)
                                                            <svg class="inline h-3 w-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                            </svg>
                                                        @endif
                                                    </a>
                                                @elseif($row[$key]['type'] === 'avatar')
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            @if($row[$key]['image'])
                                                                <img class="h-10 w-10 rounded-full" src="{{ $row[$key]['image'] }}" alt="{{ $row[$key]['name'] }}">
                                                            @else
                                                                <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                                                    <span class="text-sm font-medium text-primary-700">
                                                                        {{ substr($row[$key]['name'], 0, 2) }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-txt-black-900">{{ $row[$key]['name'] }}</div>
                                                            @if(isset($row[$key]['subtitle']))
                                                                <div class="text-sm text-txt-black-500">{{ $row[$key]['subtitle'] }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @elseif($row[$key]['type'] === 'date')
                                                    <div class="text-sm text-txt-black-900">
                                                        {{ $row[$key]['date'] }}
                                                    </div>
                                                    @if(isset($row[$key]['time']))
                                                        <div class="text-sm text-txt-black-500">
                                                            {{ $row[$key]['time'] }}
                                                        </div>
                                                    @endif
                                                @else
                                                    {{ $row[$key]['text'] ?? $row[$key] }}
                                                @endif
                                            @else
                                                <div class="text-sm text-txt-black-900">{{ $row[$key] }}</div>
                                            @endif
                                        @else
                                            <span class="text-txt-black-400">-</span>
                                        @endif
                                    </td>
                                @endforeach

                                {{-- Actions Column --}}
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium {{ $compact ? 'py-3' : 'py-4' }}">
                                    @if(isset($row['actions']) && count($row['actions']) > 0)
                                        <div class="flex items-center justify-end space-x-2">
                                            @foreach($row['actions'] as $action)
                                                @if($action['type'] === 'button')
                                                    <x-myds.button 
                                                        variant="{{ $action['variant'] ?? 'secondary' }}"
                                                        size="small"
                                                        wire:click="{{ $action['action'] }}"
                                                        :disabled="$action['disabled'] ?? false"
                                                    >
                                                        @if(isset($action['icon']))
                                                            <x-myds.icon name="{{ $action['icon'] }}" class="h-4 w-4" />
                                                        @endif
                                                        @if(isset($action['label']))
                                                            {{ $action['label'] }}
                                                        @endif
                                                    </x-myds.button>
                                                @elseif($action['type'] === 'link')
                                                    <a 
                                                        href="{{ $action['url'] }}"
                                                        class="text-primary-600 hover:text-primary-900 font-medium"
                                                        @if($action['external'] ?? false) target="_blank" @endif
                                                    >
                                                        @if(isset($action['icon']))
                                                            <x-myds.icon name="{{ $action['icon'] }}" class="h-4 w-4" />
                                                        @endif
                                                        {{ $action['label'] }}
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        {{-- Empty State --}}
                        <tr>
                            <td colspan="{{ count($headers) + ($selectable ? 2 : 1) }}" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="h-12 w-12 text-txt-black-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-lg font-medium text-txt-black-900 mb-1">{{ $emptyMessage }}</p>
                                    <p class="text-sm text-txt-black-500">Tiada rekod yang sepadan dengan kriteria carian anda.</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination and Info --}}
    @if($showPagination && $totalRecords > 0)
        <div class="px-6 py-4 border-t border-otl-divider bg-gray-50">
            <div class="flex items-center justify-between">
                {{-- Records Info --}}
                <div class="flex items-center text-sm text-txt-black-700">
                    <span>Menunjukkan</span>
                    <select 
                        wire:model.live="perPage"
                        class="mx-2 border-gray-300 rounded-md text-sm focus:ring-primary-500 focus:border-primary-500"
                    >
                        @foreach($perPageOptions as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                    <span>daripada {{ $totalRecords }} rekod</span>
                </div>

                {{-- Pagination Controls --}}
                @if($totalPages > 1)
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        {{-- Previous Page --}}
                        <button 
                            wire:click="previousPage"
                            @if($currentPage <= 1) disabled @endif
                            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-bg-white text-sm font-medium text-txt-black-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span class="sr-only">Sebelumnya</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        {{-- Page Numbers --}}
                        @php
                            $start = max(1, $currentPage - 2);
                            $end = min($totalPages, $currentPage + 2);
                        @endphp

                        @if($start > 1)
                            <button 
                                wire:click="gotoPage(1)"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-bg-white text-sm font-medium text-txt-black-700 hover:bg-gray-50"
                            >
                                1
                            </button>
                            @if($start > 2)
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-bg-white text-sm font-medium text-txt-black-700">
                                    ...
                                </span>
                            @endif
                        @endif

                        @for($page = $start; $page <= $end; $page++)
                            <button 
                                wire:click="gotoPage({{ $page }})"
                                class="relative inline-flex items-center px-4 py-2 border text-sm font-medium {{ $page === $currentPage ? 'z-10 bg-primary-50 border-primary-500 text-primary-600' : 'border-gray-300 bg-bg-white text-txt-black-700 hover:bg-gray-50' }}"
                            >
                                {{ $page }}
                            </button>
                        @endfor

                        @if($end < $totalPages)
                            @if($end < $totalPages - 1)
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-bg-white text-sm font-medium text-txt-black-700">
                                    ...
                                </span>
                            @endif
                            <button 
                                wire:click="gotoPage({{ $totalPages }})"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-bg-white text-sm font-medium text-txt-black-700 hover:bg-gray-50"
                            >
                                {{ $totalPages }}
                            </button>
                        @endif

                        {{-- Next Page --}}
                        <button 
                            wire:click="nextPage"
                            @if($currentPage >= $totalPages) disabled @endif
                            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-bg-white text-sm font-medium text-txt-black-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span class="sr-only">Seterusnya</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </nav>
                @endif
            </div>
        </div>
    @endif
</div>