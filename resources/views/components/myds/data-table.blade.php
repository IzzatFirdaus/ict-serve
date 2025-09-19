{{--
  MYDS Data Table for ICTServe (iServe)
  - Compliant with MYDS standards (Design, Develop, Colour, Icons) and MyGovEA principles
  - Accessible, responsive, high-contrast, keyboard navigable, semantic tokens
  - Props:
  headers: array of ['label'=>..., 'sortable'=>bool, ...]
  data: array of rows
  searchable: bool
  sortable: bool
  pagination: bool
  emptyStateTitle, emptyStateDescription, emptyStateIcon, actions: see below
--}}

@props([
  'headers' => [],
  'data' => [],
  'searchable' => true,
  'sortable' => true,
  'pagination' => true,
  'emptyStateTitle' => 'Tiada data dijumpai',
  'emptyStateDescription' => 'Cuba laraskan carian atau penapis anda.',
  'emptyStateIcon' => 'table',
  'actions' => [],
  'emptyStateActions' => null,
  'filters' => null,
  'paginator' => null,
])

<x-myds.tokens />

<div
  class="bg-white dark:bg-dialog border border-divider radius-l shadow-card overflow-hidden"
  {{ $attributes }}
>
  {{-- Search and Filters Section --}}
  @if ($searchable || $filters)
    <div class="p-6 border-b border-divider">
      {{ $filters ?? '' }}
    </div>
  @endif

  @if (count($data) > 0)
    <div class="overflow-x-auto">
      <table class="min-w-full font-inter" role="table">
        <thead class="bg-gray-50 dark:bg-black-100">
          <tr class="border-b border-divider">
            @foreach ($headers as $header)
              <th scope="col" class="px-6 py-3 text-left">
                @if ($sortable && ($header['sortable'] ?? false))
                  <button
                    type="button"
                    class="flex items-center gap-1 hover:txt-primary font-inter text-xs font-medium txt-black-700 dark:txt-black-300 uppercase tracking-wider focus-ring-primary"
                    aria-label="Susun mengikut {{ $header['label'] }}"
                  >
                    <span>{{ $header['label'] }}</span>
                    {{-- Sort Icon --}}
                    <x-myds.icons.chevron-down class="w-3.5 h-3.5" />
                  </button>
                @else
                  <span
                    class="font-inter text-xs font-medium txt-black-700 dark:txt-black-300 uppercase tracking-wider"
                  >
                    {{ $header['label'] }}
                  </span>
                @endif
              </th>
            @endforeach

            @if (count($actions) > 0)
              <th
                scope="col"
                class="px-6 py-3 font-inter text-xs font-medium txt-black-700 dark:txt-black-300 uppercase tracking-wider"
              >
                Tindakan
              </th>
            @endif
          </tr>
        </thead>
        <tbody class="bg-white dark:bg-dialog divide-y divide-divider">
          {{ $slot }}
        </tbody>
      </table>
    </div>
    @if ($pagination && $paginator)
      <div
        class="px-6 py-4 bg-gray-50 dark:bg-black-100 border-t border-divider"
      >
        {{ $paginator->links() }}
      </div>
    @endif
  @else
    {{-- Empty State --}}
    <div class="text-center py-12">
      @switch($emptyStateIcon)
        @case('table')
          <x-myds.icons.table
            class="w-12 h-12 txt-black-400 mx-auto mb-4"
            aria-hidden="true"
          />

          @break
        @case('document')
          <x-myds.icons.document
            class="w-12 h-12 txt-black-400 mx-auto mb-4"
            aria-hidden="true"
          />

          @break
        @default
          <x-myds.icons.search
            class="w-12 h-12 txt-black-400 mx-auto mb-4"
            aria-hidden="true"
          />
      @endswitch

      <h3
        class="font-poppins text-lg font-medium txt-black-900 dark:txt-white mb-2"
      >
        {{ $emptyStateTitle }}
      </h3>
      <p class="font-inter text-sm txt-black-500 dark:txt-black-400 mb-4">
        {{ $emptyStateDescription }}
      </p>
      {{ $emptyStateActions ?? '' }}
    </div>
  @endif
</div>
