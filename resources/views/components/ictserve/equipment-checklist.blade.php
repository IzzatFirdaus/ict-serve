@props([
    'equipment' => null,
    'checklist' => [],
    'mode' => 'view', // 'view', 'issue', 'return'
    'readonly' => false,
    'showCondition' => false,
])

@php
    $issuanceItems = [
        'device' => 'Peralatan utama',
        'power_adapter' => 'Penyesuai kuasa',
        'cable_usb' => 'Kabel USB',
        'cable_hdmi' => 'Kabel HDMI',
        'cable_ethernet' => 'Kabel Ethernet',
        'mouse' => 'Tetikus',
        'keyboard' => 'Papan kekunci',
        'bag_case' => 'Beg/Sarung',
        'manual' => 'Manual pengguna',
        'warranty_card' => 'Kad waranti',
        'accessories_other' => 'Aksesori lain',
    ];

    $conditionOptions = [
        'excellent' => 'Sangat Baik',
        'good' => 'Baik',
        'fair' => 'Sederhana',
        'poor' => 'Perlu Dibaiki',
    ];

    $conditionColors = [
        'excellent' => 'success',
        'good' => 'success',
        'fair' => 'warning',
        'poor' => 'danger',
    ];
@endphp

<div class="bg-bg-white border border-otl-divider rounded-lg p-6" {{ $attributes }}>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-semibold text-txt-black-900 font-heading">
                @switch($mode)
                    @case('issue')
                        Senarai Semak Pengeluaran
                        @break
                    @case('return')
                        Senarai Semak Pemulangan
                        @break
                    @default
                        Senarai Peralatan & Aksesori
                @endswitch
            </h3>

            @if($equipment)
                <p class="text-sm text-txt-black-600 mt-1">
                    {{ $equipment['name'] ?? 'Peralatan' }}
                    @if(isset($equipment['serial_number']))
                        (S/N: {{ $equipment['serial_number'] }})
                    @endif
                </p>
            @endif
        </div>

        @if($mode === 'issue' || $mode === 'return')
            <div class="text-sm text-txt-black-500">
                <span class="font-medium">Tarikh:</span> {{ now()->format('d/m/Y H:i') }}
            </div>
        @endif
    </div>

    {{-- Checklist Items --}}
    <div class="space-y-4">
        @foreach($issuanceItems as $key => $label)
            @php
                $isChecked = $checklist[$key]['checked'] ?? false;
                $condition = $checklist[$key]['condition'] ?? null;
                $notes = $checklist[$key]['notes'] ?? '';
                $itemId = "checklist_{$key}";
            @endphp

            <div class="flex items-start space-x-3 p-4 rounded-lg border {{ $isChecked ? 'border-otl-success-200 bg-success-50' : 'border-otl-gray-200 bg-gray-50' }} transition-colors">
                {{-- Checkbox --}}
                <div class="flex items-center h-6">
                    @if($readonly)
                        <div class="h-5 w-5 rounded flex items-center justify-center {{ $isChecked ? 'bg-success-500' : 'bg-gray-300' }}" aria-hidden="true">
                            @if($isChecked)
                                {{-- MYDS 20x20 icon --}}
                                <svg class="h-3.5 w-3.5 text-white" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l3 3 7-7" />
                                </svg>
                            @endif
                        </div>
                    @else
                        <input
                            type="checkbox"
                            id="{{ $itemId }}"
                            name="checklist[{{ $key }}][checked]"
                            value="1"
                            {{ $isChecked ? 'checked' : '' }}
                            class="h-5 w-5 text-txt-primary border-otl-gray-300 rounded focus-visible:ring-2 focus-visible:ring-fr-primary focus-visible:outline-none"
                            @if($mode !== 'view')
                                wire:model.live="checklist.{{ $key }}.checked"
                            @endif
                            aria-describedby="{{ $itemId }}-desc"
                        >
                    @endif
                </div>

                {{-- Item Details --}}
                <div class="flex-1 min-w-0">
                    <label for="{{ $itemId }}" class="block text-sm font-medium text-txt-black-900 cursor-pointer">
                        {{ $label }}
                    </label>
                    <span id="{{ $itemId }}-desc" class="sr-only">Tandakan jika item diterima</span>

                    {{-- Condition Selection --}}
                    @if($showCondition && ($isChecked || $readonly))
                        <div class="mt-2">
                            <label class="block text-xs font-medium text-txt-black-700 mb-1">
                                Keadaan:
                            </label>
                            @if($readonly)
                                @if($condition)
                                    <x-myds.badge
                                        :variant="$conditionColors[$condition] ?? 'gray'"
                                        size="sm"
                                    >
                                        {{ $conditionOptions[$condition] ?? 'Tidak Dinyatakan' }}
                                    </x-myds.badge>
                                @else
                                    <span class="text-xs text-txt-black-500">Tidak dinyatakan</span>
                                @endif
                            @else
                                <select
                                    name="checklist[{{ $key }}][condition]"
                                    class="mt-1 block w-full sm:w-auto text-sm border-otl-gray-300 rounded-md focus-visible:ring-2 focus-visible:ring-fr-primary focus-visible:outline-none"
                                    @if($mode !== 'view')
                                        wire:model.live="checklist.{{ $key }}.condition"
                                    @endif
                                    aria-label="Keadaan {{ $label }}"
                                >
                                    <option value="">Pilih keadaan</option>
                                    @foreach($conditionOptions as $value => $optLabel)
                                        <option value="{{ $value }}" {{ $condition === $value ? 'selected' : '' }}>
                                            {{ $optLabel }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    @endif

                    {{-- Notes --}}
                    @if($mode === 'return' || ($readonly && $notes))
                        <div class="mt-2">
                            <label class="block text-xs font-medium text-txt-black-700 mb-1">
                                Catatan:
                            </label>
                            @if($readonly)
                                @if($notes)
                                    <p class="text-sm text-txt-black-600">{{ $notes }}</p>
                                @else
                                    <span class="text-xs text-txt-black-500">Tiada catatan</span>
                                @endif
                            @else
                                <textarea
                                    name="checklist[{{ $key }}][notes]"
                                    placeholder="Catatan tambahan (jika ada)"
                                    rows="2"
                                    class="mt-1 block w-full text-sm border-otl-gray-300 rounded-md focus-visible:ring-2 focus-visible:ring-fr-primary focus-visible:outline-none"
                                    @if($mode !== 'view')
                                        wire:model.defer="checklist.{{ $key }}.notes"
                                    @endif
                                >{{ $notes }}</textarea>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Status Icon --}}
                <div class="flex-shrink-0">
                    @if($isChecked)
                        <div class="h-6 w-6 rounded-full bg-success-100 flex items-center justify-center" aria-hidden="true">
                            <svg class="h-4 w-4 text-txt-success" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l3 3 7-7" />
                            </svg>
                        </div>
                    @else
                        <div class="h-6 w-6 rounded-full bg-gray-200 flex items-center justify-center" aria-hidden="true">
                            <svg class="h-4 w-4 text-txt-black-400" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 10h12" />
                            </svg>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- Summary --}}
    @if($readonly)
        @php
            $totalItems = count($issuanceItems);
            $checkedItems = collect($checklist)->where('checked', true)->count();
            $completionPercentage = $totalItems > 0 ? round(($checkedItems / $totalItems) * 100) : 0;
        @endphp

        <div class="mt-6 p-4 bg-gray-50 rounded-lg" role="status" aria-live="polite">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-txt-black-700">Status Kelengkapan</span>
                <span class="text-sm font-bold text-txt-black-900">{{ $checkedItems }}/{{ $totalItems }}</span>
            </div>

            <div class="w-full bg-gray-200 rounded-full h-2" aria-hidden="true">
                <div
                    class="h-2 rounded-full transition-all duration-300 {{ $completionPercentage === 100 ? 'bg-success-500' : 'bg-primary-500' }}"
                    style="width: {{ $completionPercentage }}%"
                ></div>
            </div>

            <p class="text-xs text-txt-black-500 mt-1">
                {{ $completionPercentage }}% lengkap
            </p>
        </div>
    @endif

    {{-- Actions --}}
    @if(!$readonly && ($mode === 'issue' || $mode === 'return'))
        <div class="mt-6 pt-6 border-t border-otl-divider">
            <div class="flex items-center justify-between gap-4">
                <div class="text-sm text-txt-black-600">
                    <span class="font-medium">Petugas:</span> {{ Auth::user()->name }}
                </div>

                <div class="flex space-x-3">
                    <x-myds.button variant="secondary" wire:click="$parent.cancel">
                        Batal
                    </x-myds.button>

                    <x-myds.button
                        variant="primary"
                        wire:click="$parent.{{ $mode === 'issue' ? 'confirmIssuance' : 'confirmReturn' }}"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>
                            {{ $mode === 'issue' ? 'Sahkan Pengeluaran' : 'Sahkan Pemulangan' }}
                        </span>
                        <span wire:loading>
                            Memproses...
                        </span>
                    </x-myds.button>
                </div>
            </div>
        </div>
    @endif

    {{-- Slot for additional content --}}
    @if(isset($slot) && !empty(trim($slot)))
        <div class="mt-6 pt-6 border-t border-otl-divider">
            {{ $slot }}
        </div>
    @endif
</div>
