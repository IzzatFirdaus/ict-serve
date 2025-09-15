<!-- Loan Request Form - ICT Serve (iServe) -->
<x-myds.container>
    @php
        $crumbs = collect($breadcrumbs ?? [])->map(fn($b) => [
            'label' => $b['title'] ?? '',
            'url' => $b['url'] ?? null,
        ])->toArray();
    @endphp

    <div class="mb-6">
        <x-myds.breadcrumb :items="$crumbs" />
    </div>

    <!-- Page Header -->
    <header class="mb-8">
        <x-myds.heading level="1" variant="primary" spacing="tight">
            Mohon Pinjaman Peralatan ICT
        </x-myds.heading>
        <p class="font-inter text-sm font-normal text-txt-black-700">
            Request for ICT Equipment Loan
        </p>
        <p class="font-inter text-sm font-normal text-txt-black-500 mt-1">
            Sila lengkapkan borang di bawah untuk mohon pinjaman peralatan ICT.
            <br class="sm:hidden">
            <span class="text-txt-black-500/80">Please complete the form below to request ICT equipment loan.</span>
        </p>
    </header>

    <!-- Alert Messages -->
    @if (session()->has('message'))
        <div class="mb-6">
            <x-myds.alert variant="success" title="Berjaya / Success">
                {{ session('message') }}
            </x-myds.alert>
        </div>
    @endif

    @if ($errors->has('form'))
        <div class="mb-6">
            <x-myds.alert variant="danger" title="Ralat / Error">
                {{ $errors->first('form') }}
            </x-myds.alert>
        </div>
    @endif

    <!-- Main Form -->
    <form wire:submit="submit" class="space-y-8">
        @csrf

        <!-- Request Details Section -->
        <x-myds.card variant="elevated">
            <x-slot name="title">
                Butiran Permohonan / Request Details
            </x-slot>

            <div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Purpose -->
                    <div class="lg:col-span-2">
                        <x-myds.textarea
                            name="purpose"
                            label="Tujuan Pinjaman / Purpose of Loan"
                            :required="true"
                            maxlength="500"
                            placeholder="Nyatakan tujuan penggunaan peralatan ICT... / State the purpose of ICT equipment usage..."
                            wire:model.blur="purpose"
                            aria-describedby="purpose-help"
                        />
                        <p id="purpose-help" class="font-inter text-xs text-txt-black-500">Berikan penerangan yang jelas untuk memudahkan proses kelulusan. <span class="text-txt-black-500/80">Provide clear explanation to facilitate approval process.</span></p>
                    </div>

                    <!-- Date From -->
                    <div>
                        <x-myds.input
                            name="requested_from"
                            label="Tarikh Mula / Start Date"
                            :required="true"
                            type="date"
                            min="{{ now()->addDay()->format('Y-m-d') }}"
                            wire:model.blur="requested_from"
                        />
                    </div>

                    <!-- Date To -->
                    <div>
                        <x-myds.input
                            name="requested_to"
                            label="Tarikh Tamat / End Date"
                            :required="true"
                            type="date"
                            min="{{ $requested_from ?: now()->addDay()->format('Y-m-d') }}"
                            wire:model.blur="requested_to"
                        />
                    </div>

                    <!-- Contact Phone -->
                    <div>
                        <x-myds.input
                            name="contact_phone"
                            label="No. Telefon Perhubungan / Contact Phone"
                            type="tel"
                            placeholder="012-3456789"
                            maxlength="20"
                            wire:model.blur="contact_phone"
                            aria-describedby="phone-help"
                        />
                        <p id="phone-help" class="font-inter text-xs text-txt-black-500">Untuk dihubungi jika diperlukan. / For contact if necessary.</p>
                    </div>

                    <!-- Additional Notes -->
                    <div>
                        <x-myds.textarea
                            name="notes"
                            label="Catatan Tambahan / Additional Notes"
                            maxlength="1000"
                            placeholder="Catatan atau keperluan khas... / Additional notes or special requirements..."
                            wire:model.blur="notes"
                        />
                    </div>
                </div>
            </div>
        </x-myds.card>

        <!-- Equipment Selection Section -->
        <x-myds.card variant="elevated">
            <x-slot name="title">Pemilihan Peralatan / Equipment Selection</x-slot>
            <div>
                <!-- Equipment Categories -->
                @if(count($equipmentCategories) > 0)
                    <div class="mb-6">
                        <x-myds.heading level="3" spacing="tight">Kategori Peralatan / Equipment Categories</x-myds.heading>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($equipmentCategories as $category)
                                <button
                                    type="button"
                                    wire:click="loadEquipmentByCategory({{ $category['id'] }})"
                                    class="myds-button inline-flex items-start w-full justify-start bg-bg-white text-txt-black-900 border border-otl-gray-300 hover:bg-bg-gray-50 rounded-[var(--radius-m)] p-4 h-auto"
                                >
                                    <div class="flex items-start space-x-3">
                                        <svg class="w-5 h-5 text-txt-primary mt-1" aria-hidden="true"><title>{{ $category['name'] }}</title><circle cx="10" cy="10" r="9" fill="currentColor"/></svg>
                                        <div>
                                            <div class="font-inter text-sm font-semibold text-txt-black-900">
                                                {{ $category['name'] }}
                                            </div>
                                            @if(!empty($category['description']))
                                                <div class="font-inter text-xs text-txt-black-700 mt-1">
                                                    {{ $category['description'] }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @else
                    <x-myds.alert variant="warning">
                        Tiada Kategori Peralatan. <span class="text-txt-black-700">No equipment categories available at the moment.</span>
                    </x-myds.alert>
                @endif

                <!-- Selected Equipment -->
                @if(count($this->selectedEquipmentDetails) > 0)
                    <div class="border-t border-otl-gray-200 pt-6">
                        <x-myds.heading level="3" spacing="tight">
                            Peralatan Dipilih / Selected Equipment
                            <span class="align-middle ml-2 inline-flex items-center rounded-full bg-bg-primary-100 px-2 py-0.5 text-xs font-medium text-txt-primary">{{ count($selectedEquipment) }}</span>
                        </x-myds.heading>

                        <div class="space-y-3">
                            @foreach($this->selectedEquipmentDetails as $equipment)
                                <x-myds.card variant="bordered" padding="small">
                                    <div class="p-0">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <div class="font-inter text-sm font-semibold text-txt-black-900">
                                                    {{ $equipment['brand'] }} {{ $equipment['model'] }}
                                                </div>
                                                <div class="font-inter text-xs text-txt-black-700">
                                                    {{ $equipment['category']['name'] ?? 'N/A' }} • {{ $equipment['asset_tag'] }}
                                                </div>
                                                @if(!empty($equipment['specifications']))
                                                    <div class="font-inter text-xs text-txt-black-500 mt-1">
                                                        {{ $equipment['specifications'] }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="flex items-center space-x-3 ml-4">
                                                <!-- Quantity Input -->
                                                <div class="flex items-center space-x-2">
                                                    <label for="qty-{{ $equipment['id'] }}" class="font-inter text-xs text-txt-black-700">
                                                        Kuantiti:
                                                    </label>
                                                    <x-myds.input
                                                        name="qty-{{ $equipment['id'] }}"
                                                        type="number"
                                                        class="w-20 text-center"
                                                        min="1"
                                                        max="10"
                                                        wire:model.blur="equipmentQuantities.{{ $equipment['id'] }}"
                                                        aria-label="Quantity for {{ $equipment['brand'] }} {{ $equipment['model'] }}"
                                                    />
                                                </div>

                                                <!-- Remove Button -->
                                                <x-myds.button
                                                    type="button"
                                                    variant="danger"
                                                    size="small"
                                                    wire:click="removeEquipment({{ $equipment['id'] }})"
                                                    aria-label="Remove {{ $equipment['brand'] }} {{ $equipment['model'] }} from selection"
                                                >
                                                    Buang
                                                </x-myds.button>
                                            </div>
                                        </div>
                                    </div>
                                </x-myds.card>
                            @endforeach
                        </div>
                    </div>
                @else
                    @error('selectedEquipment')
                        <x-myds.alert variant="warning">{{ $message }}</x-myds.alert>
                    @enderror
                @endif
            </div>
        </x-myds.card>

        <!-- Form Actions -->
        <x-myds.card variant="elevated">
            <div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="font-inter text-sm text-txt-black-700">
                        Permohonan akan dihantar kepada penyelia untuk kelulusan.
                        <br class="sm:hidden">
                        <span class="text-txt-black-500">Request will be sent to supervisor for approval.</span>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <x-myds.button variant="secondary" :href="route('loan.index')" wire:navigate>
                            Batal / Cancel
                        </x-myds.button>

                        <x-myds.button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="submit">
                            <span wire:loading.remove wire:target="submit">Hantar Permohonan / Submit Request</span>
                            <span wire:loading wire:target="submit" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Menghantar...
                            </span>
                        </x-myds.button>
                    </div>
                </div>
            </div>
        </x-myds.card>
    </form>

    <!-- Equipment Selection Modal -->
    @if($showEquipmentModal)
        <x-myds.modal :open="$showEquipmentModal" maxWidth="3xl">
            <div class="bg-bg-white p-6">
                <div class="flex items-start justify-between mb-4">
                    <x-myds.heading level="3" spacing="tight">Pilih Peralatan / Select Equipment</x-myds.heading>
                    <x-myds.button type="button" variant="outline" size="small" wire:click="closeEquipmentModal" aria-label="Close modal">Tutup</x-myds.button>
                </div>

                @if(count($availableEquipment) > 0)
                    <div class="space-y-3">
                        @foreach($availableEquipment as $equipment)
                            <x-myds.card variant="bordered" padding="small">
                                <div class="flex items-start space-x-4">
                                    <input
                                        type="checkbox"
                                        id="equipment-{{ $equipment['id'] }}"
                                        class="rounded border-otl-gray-200 mt-1 h-5 w-5"
                                        wire:click="toggleEquipment({{ $equipment['id'] }})"
                                        @if(in_array($equipment['id'], $selectedEquipment)) checked @endif
                                    />

                                    <label for="equipment-{{ $equipment['id'] }}" class="flex-1 cursor-pointer">
                                        <div class="font-inter text-sm font-semibold text-txt-black-900">
                                            {{ $equipment['brand'] }} {{ $equipment['model'] }}
                                        </div>
                                        <div class="font-inter text-xs text-txt-black-700">
                                            {{ $equipment['asset_tag'] }}
                                            @if(!empty($equipment['serial_number']))
                                                • S/N: {{ $equipment['serial_number'] }}
                                            @endif
                                        </div>
                                        @if(!empty($equipment['specifications']))
                                            <div class="font-inter text-xs text-txt-black-500 mt-1">
                                                {{ $equipment['specifications'] }}
                                            </div>
                                        @endif
                                        @if(!empty($equipment['location']))
                                            <div class="font-inter text-xs text-txt-black-500 mt-1">
                                                {{ $equipment['location'] }}
                                            </div>
                                        @endif
                                    </label>

                                    <span class="inline-flex items-center rounded-full bg-bg-success-100 px-2 py-0.5 text-xs font-medium text-txt-success">{{ ucfirst($equipment['status']) }}</span>
                                </div>
                            </x-myds.card>
                        @endforeach
                    </div>
                @else
                    <x-myds.alert>Tiada Peralatan Tersedia. <span class="text-txt-black-700">No equipment available in this category at the moment.</span></x-myds.alert>
                @endif

                <div class="mt-6 flex justify-end">
                    <x-myds.button type="button" variant="primary" wire:click="closeEquipmentModal">
                        Selesai / Done
                        @if(count($selectedEquipment) > 0)
                            <span class="ml-2 inline-flex items-center rounded-full bg-bg-white px-2 py-0.5 text-xs font-medium text-txt-black-900">{{ count($selectedEquipment) }}</span>
                        @endif
                    </x-myds.button>
                </div>
            </div>
        </x-myds.modal>
    @endif
</x-myds.container>

<!-- Minor enhancement: keep client-side date min adjustment -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fromDate = document.getElementById('requested_from');
        const toDate = document.getElementById('requested_to');
        if (fromDate && toDate) {
            fromDate.addEventListener('change', () => {
                toDate.min = fromDate.value;
                if (toDate.value && toDate.value <= fromDate.value) {
                    const nextDay = new Date(fromDate.value);
                    nextDay.setDate(nextDay.getDate() + 1);
                    toDate.value = nextDay.toISOString().split('T')[0];
                }
            });
        }
    });
</script>
