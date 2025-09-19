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
  'perPageOptions' => [
    10,
    25,
    50,
    100,
  ],
  'currentPage' => 1,
  'totalPages' => 1,
  'totalRecords' => 0,
  'loading' => false,
  'selectable' => false,
  'selectedIds' => [],
  'actions' => [],
  'compact' => false,
  'caption' => 'Jadual data',
  //Accessibletablecaption(sr-only)'tableLabelledBy' => null,
  //optionalidtolabeltheregion,
])

@php
  $ariaSort = function ($key, $currentSort, $sortDirection) {
    if ($currentSort === $key) {
      return $sortDirection === 'asc' ? 'ascending' : 'descending';
    }
    return 'none';
  };
@endphp

<div
  class="bg-bg-white shadow-card rounded-lg border border-otl-divider overflow-hidden"
  {{ $attributes->merge(['role' => 'region']) }}
  @if($tableLabelledBy) aria-labelledby="{{ $tableLabelledBy }}" @else aria-label="Jadual" @endif
>
  {{-- Table Header with Search and Actions --}}
  @if ($searchable || count($actions) > 0)
    <div class="px-6 py-4 border-b border-otl-divider bg-gray-50">
      <div class="flex items-center justify-between gap-4">
        {{-- Search Bar --}}
        @if ($searchable)
          <div class="flex-1 max-w-md">
            <div class="relative">
              <div
                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
              >
                {{-- MYDS 20x20, 1.5 stroke --}}
                <svg
                  class="h-5 w-5 text-txt-black-400"
                  viewBox="0 0 20 20"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="1.5"
                  aria-hidden="true"
                >
                  <circle cx="9" cy="9" r="6"></circle>
                  <path stroke-linecap="round" d="M14 14l4 4"></path>
                </svg>
              </div>
              <x-myds.input
                type="text"
                placeholder="{{ $searchPlaceholder }}"
                class="pl-10"
                wire:model.live.debounce.300ms="search"
                aria-label="Carian jadual"
              />
            </div>
          </div>
        @endif

        {{-- Table Actions --}}
        @if (count($actions) > 0)
          <div
            class="flex items-center space-x-3 {{ $searchable ? 'ml-6' : '' }}"
          >
            @foreach ($actions as $action)
              @if ($action['type'] === 'button')
                <x-myds.button
                  variant="{{ $action['variant'] ?? 'secondary' }}"
                  size="{{ $action['size'] ?? 'medium' }}"
                  wire:click="{{ $action['action'] ?? '' }}"
                  :disabled="$action['disabled'] ?? false"
                >
                  @if (isset($action['icon']))
                    <x-myds.icon
                      name="{{ $action['icon'] }}"
                      class="mr-2 h-4 w-4"
                    />
                  @endif

                  {{ $action['label'] }}
                </x-myds.button>
              @elseif ($action['type'] === 'dropdown')
                <div class="relative" x-data="{ open: false }">
                  <x-myds.button
                    variant="secondary"
                    @click="open = !open"
                    class="relative"
                    aria-haspopup="menu"
                    :aria-expanded="open"
                  >
                    {{ $action['label'] }}
                    <svg
                      class="ml-2 h-4 w-4"
                      viewBox="0 0 20 20"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="1.5"
                      aria-hidden="true"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 7l5 6 5-6"
                      />
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
                    class="absolute right-0 z-10 mt-2 w-48 rounded-lg shadow-context-menu bg-bg-white ring-1 ring-otl-divider"
                    role="menu"
                    aria-label="Tindakan Jadual"
                  >
                    <div class="py-1">
                      @foreach ($action['items'] as $item)
                        <button
                          wire:click="{{ $item['action'] }}"
                          @click="open = false"
                          class="block w-full text-left px-4 py-2 text-sm text-txt-black-700 hover:bg-gray-50 hover:text-txt-black-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
                          role="menuitem"
                        >
                          @if (isset($item['icon']))
                            <x-myds.icon
                              name="{{ $item['icon'] }}"
                              class="mr-2 h-4 w-4 inline"
                            />
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
      <table class="min-w-full divide-y divide-otl-divider" role="table">
        <caption class="sr-only">{{ $caption }}</caption>

        {{-- Table Head (sticky) --}}
        <thead class="bg-gray-50 sticky top-0 z-10" role="rowgroup">
          <tr role="row">
            {{-- Select All Checkbox --}}
            @if ($selectable)
              <th scope="col" class="relative w-12 px-6 sm:w-16 sm:px-8">
                <x-myds.checkbox
                  wire:model.live="selectAll"
                  class="absolute left-4 top-1/2 -mt-2 h-4 w-4 sm:left-6"
                  aria-label="Pilih semua baris"
                />
              </th>
            @endif

            {{-- Column Headers --}}
            @foreach ($headers as $key => $header)
              <th
                scope="col"
                class="px-6 {{ $compact ? 'py-2' : 'py-3' }} text-left text-xs font-medium text-txt-black-500 uppercase tracking-wider"
                @if(in_array($key, $sortable)) aria-sort="{{ $ariaSort($key, $currentSort, $sortDirection) }}" @endif
              >
                @if (in_array($key, $sortable))
                  <button
                    wire:click="sortBy('{{ $key }}')"
                    class="group inline-flex items-center hover:text-txt-black-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded"
                    aria-label="Isih lajur {{ $header }}"
                  >
                    {{ $header }}
                    <span class="ml-2 flex-none rounded" aria-hidden="true">
                      @if ($currentSort === $key)
                        @if ($sortDirection === 'asc')
                          <svg
                            class="h-4 w-4 text-txt-black-400"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                          >
                            <path
                              fill-rule="evenodd"
                              d="M10 7l5 6H5l5-6z"
                              clip-rule="evenodd"
                            />
                          </svg>
                        @else
                          <svg
                            class="h-4 w-4 text-txt-black-400"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                          >
                            <path
                              fill-rule="evenodd"
                              d="M10 13l-5-6h10l-5 6z"
                              clip-rule="evenodd"
                            />
                          </svg>
                        @endif
                      @else
                        <svg
                          class="h-4 w-4 text-txt-black-300 group-hover:text-txt-black-400"
                          viewBox="0 0 20 20"
                          fill="currentColor"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M10 13l-5-6h10l-5 6z"
                            clip-rule="evenodd"
                          />
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
            <th
              scope="col"
              class="relative px-6 {{ $compact ? 'py-2' : 'py-3' }}"
            >
              <span class="sr-only">Tindakan</span>
            </th>
          </tr>
        </thead>

        {{-- Table Body --}}
        <tbody class="bg-bg-white divide-y divide-otl-divider" role="rowgroup">
          @if ($loading)
            {{-- Loading State (skeleton) --}}
            @for ($i = 0; $i < 5; $i++)
              <tr role="row">
                @if ($selectable)
                  <td class="w-12 px-6 sm:w-16 sm:px-8">
                    <div
                      class="h-4 w-4 bg-gray-200 rounded animate-pulse"
                      aria-hidden="true"
                    ></div>
                  </td>
                @endif

                @foreach ($headers as $header)
                  <td
                    class="px-6 {{ $compact ? 'py-3' : 'py-4' }} whitespace-nowrap"
                  >
                    <div
                      class="h-4 bg-gray-200 rounded animate-pulse"
                      aria-hidden="true"
                    ></div>
                  </td>
                @endforeach

                <td
                  class="px-6 {{ $compact ? 'py-3' : 'py-4' }} whitespace-nowrap"
                >
                  <div
                    class="h-8 w-20 bg-gray-200 rounded animate-pulse"
                    aria-hidden="true"
                  ></div>
                </td>
              </tr>
            @endfor
          @elseif (count($data) > 0)
            {{-- Data Rows --}}
            @foreach ($data as $index => $row)
              <tr
                class="hover:bg-gray-50 focus-within:bg-primary-50 {{ in_array($row['id'] ?? $index, $selectedIds) ? 'bg-primary-50' : '' }}"
                role="row"
              >
                {{-- Select Checkbox --}}
                @if ($selectable)
                  <td class="relative w-12 px-6 sm:w-16 sm:px-8">
                    <x-myds.checkbox
                      wire:model.live="selectedIds"
                      value="{{ $row['id'] ?? $index }}"
                      class="absolute left-4 top-1/2 -mt-2 h-4 w-4 sm:left-6"
                      aria-label="Pilih baris {{ $index + 1 }}"
                    />
                  </td>
                @endif

                {{-- Data Cells --}}
                @foreach ($headers as $key => $header)
                  <td
                    class="px-6 {{ $compact ? 'py-3' : 'py-4' }} whitespace-nowrap"
                  >
                    @if (isset($row[$key]))
                      @if (is_array($row[$key]) && isset($row[$key]['type']))
                        {{-- Special cell types --}}
                        @if ($row[$key]['type'] === 'badge')
                          <x-myds.badge
                            variant="{{ $row[$key]['variant'] ?? 'gray' }}"
                            size="{{ $row[$key]['size'] ?? 'medium' }}"
                          >
                            {{ $row[$key]['text'] }}
                          </x-myds.badge>
                        @elseif ($row[$key]['type'] === 'link')
                          <a
                            href="{{ $row[$key]['url'] }}"
                            class="text-txt-primary hover:text-primary-700 font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded"
                            @if($row[$key]['external'] ?? false) target="_blank" rel="noopener" @endif
                            aria-label="Pautan {{ $row[$key]['text'] }}"
                          >
                            {{ $row[$key]['text'] }}
                            @if ($row[$key]['external'] ?? false)
                              <svg
                                class="inline h-3 w-3 ml-1"
                                viewBox="0 0 20 20"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.5"
                                aria-hidden="true"
                              >
                                <path
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M8 6h6v6M6 14l8-8"
                                />
                              </svg>
                            @endif
                          </a>
                        @elseif ($row[$key]['type'] === 'avatar')
                          <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                              @if ($row[$key]['image'])
                                <img
                                  class="h-10 w-10 rounded-full"
                                  src="{{ $row[$key]['image'] }}"
                                  alt="{{ $row[$key]['name'] }}"
                                />
                              @else
                                <div
                                  class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center"
                                >
                                  <span
                                    class="text-sm font-medium text-txt-primary"
                                  >
                                    {{ substr($row[$key]['name'], 0, 2) }}
                                  </span>
                                </div>
                              @endif
                            </div>
                            <div class="ml-4">
                              <div
                                class="text-sm font-medium text-txt-black-900"
                              >
                                {{ $row[$key]['name'] }}
                              </div>
                              @if (isset($row[$key]['subtitle']))
                                <div class="text-sm text-txt-black-500">
                                  {{ $row[$key]['subtitle'] }}
                                </div>
                              @endif
                            </div>
                          </div>
                        @elseif ($row[$key]['type'] === 'date')
                          <div class="text-sm text-txt-black-900">
                            {{ $row[$key]['date'] }}
                          </div>
                          @if (isset($row[$key]['time']))
                            <div class="text-sm text-txt-black-500">
                              {{ $row[$key]['time'] }}
                            </div>
                          @endif
                        @else
                          {{ $row[$key]['text'] ?? $row[$key] }}
                        @endif
                      @else
                        <div class="text-sm text-txt-black-900">
                          {{ $row[$key] }}
                        </div>
                      @endif
                    @else
                      <span class="text-txt-black-400">-</span>
                    @endif
                  </td>
                @endforeach

                {{-- Actions Column --}}
                <td
                  class="px-6 {{ $compact ? 'py-3' : 'py-4' }} whitespace-nowrap text-right text-sm font-medium"
                >
                  @if (isset($row['actions']) && count($row['actions']) > 0)
                    <div class="flex items-center justify-end space-x-2">
                      @foreach ($row['actions'] as $action)
                        @if ($action['type'] === 'button')
                          <x-myds.button
                            variant="{{ $action['variant'] ?? 'secondary' }}"
                            size="small"
                            wire:click="{{ $action['action'] }}"
                            :disabled="$action['disabled'] ?? false"
                          >
                            @if (isset($action['icon']))
                              <x-myds.icon
                                name="{{ $action['icon'] }}"
                                class="h-4 w-4"
                              />
                            @endif

                            @if (isset($action['label']))
                              {{ $action['label'] }}
                            @endif
                          </x-myds.button>
                        @elseif ($action['type'] === 'link')
                          <a
                            href="{{ $action['url'] }}"
                            class="text-txt-primary hover:text-primary-700 font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded"
                            @if($action['external'] ?? false) target="_blank" rel="noopener" @endif
                          >
                            @if (isset($action['icon']))
                              <x-myds.icon
                                name="{{ $action['icon'] }}"
                                class="h-4 w-4"
                              />
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
            <tr role="row">
              <td
                colspan="{{ count($headers) + ($selectable ? 2 : 1) }}"
                class="px-6 py-12 text-center"
              >
                <div class="flex flex-col items-center">
                  <svg
                    class="h-12 w-12 text-txt-black-300 mb-4"
                    viewBox="0 0 20 20"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    aria-hidden="true"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M4 5h6l4 4v6a2 2 0 01-2 2H4a2 2 0 01-2-2V7a2 2 0 012-2z"
                    />
                  </svg>
                  <p class="text-lg font-medium text-txt-black-900 mb-1">
                    {{ $emptyMessage }}
                  </p>
                  <p class="text-sm text-txt-black-500">
                    Tiada rekod yang sepadan dengan kriteria carian anda.
                  </p>
                </div>
              </td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>

  {{-- Pagination and Info --}}
  @if ($showPagination && $totalRecords > 0)
    <div class="px-6 py-4 border-t border-otl-divider bg-gray-50">
      <div class="flex items-center justify-between gap-4">
        {{-- Records Info --}}
        <div class="flex items-center text-sm text-txt-black-700">
          <span>Menunjukkan</span>
          <label for="perPage" class="sr-only">Rekod per halaman</label>
          <select
            id="perPage"
            wire:model.live="perPage"
            class="mx-2 border-otl-gray-300 rounded-md text-sm focus-visible:ring-2 focus-visible:ring-fr-primary focus-visible:outline-none"
            aria-label="Rekod per halaman"
          >
            @foreach ($perPageOptions as $option)
              <option value="{{ $option }}">{{ $option }}</option>
            @endforeach
          </select>
          <span>daripada {{ $totalRecords }} rekod</span>
        </div>

        {{-- Pagination Controls --}}
        @if ($totalPages > 1)
          <nav
            class="relative z-0 inline-flex rounded-md shadow-button -space-x-px"
            aria-label="Pagination"
          >
            {{-- Previous Page --}}
            <button
              wire:click="previousPage"
              @if($currentPage <= 1) disabled @endif
              class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-otl-gray-300 bg-bg-white text-sm font-medium text-txt-black-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
              aria-label="Halaman sebelumnya"
            >
              <svg
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                aria-hidden="true"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M12 5l-5 5 5 5"
                />
              </svg>
            </button>

            {{-- Page Numbers --}}
            @php
              $start = max(1, $currentPage - 2);
              $end = min($totalPages, $currentPage + 2);
            @endphp

            @if ($start > 1)
              <button
                wire:click="gotoPage(1)"
                class="relative inline-flex items-center px-4 py-2 border border-otl-gray-300 bg-bg-white text-sm font-medium text-txt-black-700 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
                aria-label="Pergi ke halaman 1"
              >
                1
              </button>
              @if ($start > 2)
                <span
                  class="relative inline-flex items-center px-4 py-2 border border-otl-gray-300 bg-bg-white text-sm font-medium text-txt-black-700"
                  aria-hidden="true"
                >
                  ...
                </span>
              @endif
            @endif

            @for ($page = $start; $page <= $end; $page++)
              <button
                wire:click="gotoPage({{ $page }})"
                class="relative inline-flex items-center px-4 py-2 border text-sm font-medium {{ $page === $currentPage ? 'z-10 bg-primary-50 border-otl-primary-300 text-txt-primary' : 'border-otl-gray-300 bg-bg-white text-txt-black-700 hover:bg-gray-50' }} focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
                aria-current="{{ $page === $currentPage ? 'page' : 'false' }}"
                aria-label="Pergi ke halaman {{ $page }}"
              >
                {{ $page }}
              </button>
            @endfor

            @if ($end < $totalPages)
              @if ($end < $totalPages - 1)
                <span
                  class="relative inline-flex items-center px-4 py-2 border border-otl-gray-300 bg-bg-white text-sm font-medium text-txt-black-700"
                  aria-hidden="true"
                >
                  ...
                </span>
              @endif

              <button
                wire:click="gotoPage({{ $totalPages }})"
                class="relative inline-flex items-center px-4 py-2 border border-otl-gray-300 bg-bg-white text-sm font-medium text-txt-black-700 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
                aria-label="Pergi ke halaman terakhir {{ $totalPages }}"
              >
                {{ $totalPages }}
              </button>
            @endif

            {{-- Next Page --}}
            <button
              wire:click="nextPage"
              @if($currentPage >= $totalPages) disabled @endif
              class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-otl-gray-300 bg-bg-white text-sm font-medium text-txt-black-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
              aria-label="Halaman seterusnya"
            >
              <svg
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                aria-hidden="true"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M8 5l5 5-5 5"
                />
              </svg>
            </button>
          </nav>
        @endif
      </div>
    </div>
  @endif
</div>
