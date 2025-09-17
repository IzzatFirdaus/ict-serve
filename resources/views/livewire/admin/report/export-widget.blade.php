{{--
    ICTServe (iServe) – Export Reports Widget
    - MYDS: Card, Table, Select, Button, Icon, Spacing, A11y, Colour tokens
    - MyGovEA: Citizen-centric, error prevention, clear hierarchy, responsive, accessible
--}}

<section aria-labelledby="export-widget-title" class="mb-8">
    <div class="bg-white shadow-card rounded-lg p-6 md:p-8 max-w-xl mx-auto">
        <h2 id="export-widget-title" class="text-lg md:text-2xl font-semibold text-txt-black-900 mb-4 flex items-center gap-2">
            {{-- MYDS "download" icon (20x20, 1.5px stroke) --}}
            <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                <path d="M10 3v9m0 0l-3-3m3 3l3-3M4 14.5V17a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-2.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            {{ __('Export Reports') }}
        </h2>

        {{-- Report Type Selection --}}
        <div class="mb-5">
            <label for="reportType" class="block text-sm font-medium text-txt-black-700 mb-2">
                {{ __('Report Type') }}
            </label>
            <div class="relative">
                <select
                    id="reportType"
                    wire:model="reportType"
                    class="w-full appearance-none border otl-gray-300 rounded radius-s px-3 py-2 bg-white text-txt-black-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary focus-visible:ring-offset-2 transition disabled:bg-white-disabled"
                    aria-describedby="reportType-desc"
                >
                    <option value="all">{{ __('Complete Dashboard Report') }}</option>
                    <option value="loans">{{ __('Loan Requests Only') }}</option>
                    <option value="helpdesk">{{ __('Helpdesk Tickets Only') }}</option>
                    <option value="equipment">{{ __('Equipment Only') }}</option>
                </select>
                {{-- Down-chevron icon (MYDS style) --}}
                <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </div>
            <p id="reportType-desc" class="text-xs text-txt-black-500 mt-1">
                {{ __('Choose the data scope to export.') }}
            </p>
        </div>

        {{-- Export Format Selection --}}
        <div class="mb-5">
            <label class="block text-sm font-medium text-txt-black-700 mb-2">
                {{ __('Export Format') }}
            </label>
            <div class="flex gap-2">
                <button
                    type="button"
                    wire:click="$set('exportType', 'excel')"
                    class="flex items-center gap-1 px-4 py-2 rounded radius-s border transition
                        @if($exportType === 'excel')
                            bg-success-600 text-white border-success-600
                        @else
                            bg-white text-txt-black-700 border-otl-gray-300 hover:bg-success-50
                        @endif
                        focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
                    aria-pressed="{{ $exportType === 'excel' ? 'true' : 'false' }}"
                >
                    {{-- MYDS excel/file-spreadsheet icon --}}
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20" aria-hidden="true">
                        <rect x="3" y="3" width="14" height="14" rx="2" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M7 7l6 6M13 7l-6 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    {{ __('Excel (.xlsx)') }}
                </button>
                <button
                    type="button"
                    wire:click="$set('exportType', 'csv')"
                    class="flex items-center gap-1 px-4 py-2 rounded radius-s border transition
                        @if($exportType === 'csv')
                            bg-primary-600 text-white border-primary-600
                        @else
                            bg-white text-txt-black-700 border-otl-gray-300 hover:bg-primary-50
                        @endif
                        focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
                    aria-pressed="{{ $exportType === 'csv' ? 'true' : 'false' }}"
                >
                    {{-- MYDS file-text icon --}}
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20" aria-hidden="true">
                        <rect x="3" y="3" width="14" height="14" rx="2" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M7 7h6M7 10h6M7 13h4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    {{ __('CSV') }}
                </button>
            </div>
        </div>

        {{-- Export Button --}}
        <div class="mb-2">
            <button
                type="button"
                wire:click="export"
                class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded radius-m shadow-button transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary focus-visible:ring-offset-2"
                aria-label="{{ __('Download Export') }}"
            >
                {{-- MYDS download icon --}}
                <svg class="w-5 h-5" fill="none" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M10 3v9m0 0l-3-3m3 3l3-3M4 14.5V17a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-2.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="font-medium">{{ __('Download Export') }}</span>
            </button>
        </div>

        {{-- Export Info / Description --}}
        <div class="mt-4 p-3 rounded radius-s bg-washed border otl-divider">
            <p class="text-sm text-txt-black-700" aria-live="polite">
                @if($reportType === 'all')
                    {{ __('Complete report includes all loan requests, helpdesk tickets, and equipment data.') }}
                @elseif($reportType === 'loans')
                    {{ __('Export will include loan request data with user details and status information.') }}
                @elseif($reportType === 'helpdesk')
                    {{ __('Export will include helpdesk ticket data with categories and resolution status.') }}
                @elseif($reportType === 'equipment')
                    {{ __('Export will include equipment inventory with specifications and status.') }}
                @endif
            </p>
            <p class="text-xs text-txt-black-500 mt-1">
                {{ __('Export format: ') }}<strong>{{ strtoupper($exportType) }}</strong>
            </p>
        </div>
    </div>
</section>
