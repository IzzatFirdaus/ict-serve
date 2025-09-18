{{--
    ICTServe (iServe) - ICT Equipment Loan Application (MYDS & MyGovEA Compliant)
    - MYDS: Breadcrumb, Card, Input, Select, Textarea, Button, Modal, Alert, Icon
    - Follows 12/8/4 grid, semantic tokens, accessible structure, responsive on all devices
    - Citizen-centric (MyGovEA): bilingual, clear, minimal input burden, error prevention, accessibility
--}}

<x-myds.skiplink href="#main-content">
    <span>Skip to main content</span>
</x-myds.skiplink>

<x-myds.masthead>
    <x-myds.masthead-header>
        <x-myds.masthead-title>
            <x-myds.icon name="laptop" class="mr-3" /> Mohon Pinjaman Peralatan ICT
        </x-myds.masthead-title>
    </x-myds.masthead-header>
    <x-myds.masthead-content>
        <x-myds.masthead-section title="Permohonan Pinjaman ICT" icon="hand-raised" />
    </x-myds.masthead-content>
</x-myds.masthead>

<main id="main-content" tabindex="0" class="myds-container max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

    {{-- Breadcrumb --}}
    <x-myds.breadcrumb>
        @foreach($breadcrumbs as $breadcrumb)
            <x-myds.breadcrumb-item>
                @if(isset($breadcrumb['url']))
                    <x-myds.breadcrumb-link :href="$breadcrumb['url']">{{ $breadcrumb['title'] }}</x-myds.breadcrumb-link>
                @else
                    <x-myds.breadcrumb-page>{{ $breadcrumb['title'] }}</x-myds.breadcrumb-page>
                @endif
            </x-myds.breadcrumb-item>
        @endforeach
    </x-myds.breadcrumb>

    {{-- Page header --}}
    <header class="mb-8">
        <h1 class="text-heading-xl text-txt-primary font-semibold flex items-center gap-3">
            <x-myds.icon name="laptop" class="w-8 h-8" />
            Mohon Pinjaman Peralatan ICT
        </h1>
        <div class="text-body-md text-txt-black-700 mt-2 mb-1">
            Request for ICT Equipment Loan
        </div>
        <div class="text-body-sm text-txt-black-500">
            Sila lengkapkan borang di bawah untuk mohon pinjaman peralatan ICT.<br>
            <span class="text-txt-black-400">Please complete the form below to request ICT equipment loan.</span>
        </div>
    </header>

    {{-- Alert Messages --}}
    @if (session()->has('message'))
        <x-myds.callout variant="success">
            <x-myds.icon name="check-circle" class="w-5 h-5" />
            <span>{{ session('message') }}</span>
        </x-myds.callout>
    @endif
    @if ($errors->has('form'))
        <x-myds.callout variant="danger">
            <x-myds.icon name="x-circle" class="w-5 h-5" />
            <span>{{ $errors->first('form') }}</span>
        </x-myds.callout>
    @endif

    {{-- Main Form --}}
    <form wire:submit.prevent="submit" class="myds-space-y-8" aria-label="ICT Equipment Loan Application">
        @csrf

        {{-- Request Details --}}
        <x-myds.card>
            <x-myds.card-header>
                <span class="text-heading-lg text-txt-black-900 flex items-center gap-2">
                    <x-myds.icon name="document-text" class="w-6 h-6" />
                    Butiran Permohonan / Request Details
                </span>
            </x-myds.card-header>
            <x-myds.card-body>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Purpose --}}
                    <x-myds.field class="md:col-span-2">
                        <x-myds.textarea
                            id="purpose"
                            name="purpose"
                            label="Tujuan Pinjaman / Purpose of Loan"
                            wire:model="purpose"
                            rows="3"
                            maxlength="500"
                            required
                            :invalid="$errors->has('purpose')"
                            hint="Berikan penerangan yang jelas untuk memudahkan proses kelulusan. / Provide clear explanation to facilitate approval process."
                        />
                        @error('purpose')
                            <x-myds.input-error>{{ $message }}</x-myds.input-error>
                        @enderror
                    </x-myds.field>

                    {{-- Date From --}}
                    <x-myds.field>
                        <x-myds.input
                            id="requested_from"
                            name="requested_from"
                            label="Tarikh Mula / Start Date"
                            type="date"
                            wire:model="requested_from"
                            min="{{ now()->addDay()->format('Y-m-d') }}"
                            required
                            :invalid="$errors->has('requested_from')"
                        />
                        @error('requested_from')
                            <x-myds.input-error>{{ $message }}</x-myds.input-error>
                        @enderror
                    </x-myds.field>

                    {{-- Date To --}}
                    <x-myds.field>
                        <x-myds.input
                            id="requested_to"
                            name="requested_to"
                            label="Tarikh Tamat / End Date"
                            type="date"
                            wire:model="requested_to"
                            min="{{ $requested_from ?: now()->addDay()->format('Y-m-d') }}"
                            required
                            :invalid="$errors->has('requested_to')"
                        />
                        @error('requested_to')
                            <x-myds.input-error>{{ $message }}</x-myds.input-error>
                        @enderror
                    </x-myds.field>

                    {{-- Contact Phone --}}
                    <x-myds.field>
                        <x-myds.input
                            id="contact_phone"
                            name="contact_phone"
                            label="No. Telefon Perhubungan / Contact Phone"
                            type="tel"
                            wire:model="contact_phone"
                            maxlength="20"
                            placeholder="012-3456789"
                            :invalid="$errors->has('contact_phone')"
                            hint="Untuk dihubungi jika diperlukan. / For contact if necessary."
                        />
                        @error('contact_phone')
                            <x-myds.input-error>{{ $message }}</x-myds.input-error>
                        @enderror
                    </x-myds.field>

                    {{-- Additional Notes --}}
                    <x-myds.field>
                        <x-myds.textarea
                            id="notes"
                            name="notes"
                            label="Catatan Tambahan / Additional Notes"
                            wire:model="notes"
                            rows="3"
                            maxlength="1000"
                            placeholder="Catatan atau keperluan khas... / Additional notes or special requirements..."
                            :invalid="$errors->has('notes')"
                        />
                        @error('notes')
                            <x-myds.input-error>{{ $message }}</x-myds.input-error>
                        @enderror
                    </x-myds.field>
                </div>
            </x-myds.card-body>
        </x-myds.card>

        {{-- Equipment Selection --}}
        <x-myds.card>
            <x-myds.card-header>
                <span class="text-heading-lg text-txt-black-900 flex items-center gap-2">
                    <x-myds.icon name="desktop-computer" class="w-6 h-6" />
                    Pemilihan Peralatan / Equipment Selection
                </span>
            </x-myds.card-header>
            <x-myds.card-body>
                {{-- Equipment Categories --}}
                @if(count($equipmentCategories) > 0)
                    <div class="mb-6">
                        <h3 class="text-heading-md text-txt-black-800 mb-4">
                            Kategori Peralatan / Equipment Categories
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($equipmentCategories as $category)
                                <x-myds.button
                                    type="button"
                                    variant="secondary"
                                    class="w-full text-left p-4 h-auto"
                                    wire:click="loadEquipmentByCategory({{ $category['id'] }})"
                                >
                                    <div class="flex items-start gap-3">
                                        <x-myds.icon :name="$category['icon'] ?? 'desktop-computer'" class="text-primary-600 mt-1" />
                                        <div>
                                            <div class="text-body-md font-semibold text-txt-black-900">
                                                {{ $category['name'] }}
                                            </div>
                                            @if(!empty($category['description']))
                                                <div class="text-body-sm text-txt-black-600 mt-1">
                                                    {{ $category['description'] }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </x-myds.button>
                            @endforeach
                        </div>
                    </div>
                @else
                    <x-myds.callout variant="warning" class="text-center">
                        <x-myds.icon name="exclamation-triangle" class="w-6 h-6" />
                        Tiada kategori peralatan. No equipment categories available at the moment.
                    </x-myds.callout>
                @endif

                {{-- Selected Equipment --}}
                @if(count($this->selectedEquipmentDetails) > 0)
                    <div class="border-t border-otl-divider pt-6">
                        <h3 class="text-heading-md text-txt-black-800 mb-4">
                            Peralatan Dipilih / Selected Equipment
                            <x-myds.badge variant="primary" class="ml-2">{{ count($selectedEquipment) }}</x-myds.badge>
                        </h3>
                        <div class="space-y-3">
                            @foreach($this->selectedEquipmentDetails as $equipment)
                                <x-myds.card variant="bordered">
                                    <x-myds.card-body class="p-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <div class="text-body-md font-semibold text-txt-black-900">
                                                    {{ $equipment['brand'] }} {{ $equipment['model'] }}
                                                </div>
                                                <div class="text-body-sm text-txt-black-600">
                                                    {{ $equipment['category']['name'] ?? 'N/A' }} • {{ $equipment['asset_tag'] }}
                                                </div>
                                                @if(!empty($equipment['specifications']))
                                                    <div class="text-body-sm text-txt-black-500 mt-1">
                                                        {{ $equipment['specifications'] }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-3 ml-4">
                                                {{-- Quantity Input --}}
                                                <div class="flex items-center gap-2">
                                                    <label for="qty-{{ $equipment['id'] }}" class="text-body-sm text-txt-black-600">Kuantiti:</label>
                                                    <x-myds.input
                                                        id="qty-{{ $equipment['id'] }}"
                                                        type="number"
                                                        wire:model="equipmentQuantities.{{ $equipment['id'] }}"
                                                        class="w-16 text-center"
                                                        min="1"
                                                        max="10"
                                                        size="sm"
                                                        aria-label="Quantity for {{ $equipment['brand'] }} {{ $equipment['model'] }}"
                                                    />
                                                </div>
                                                <x-myds.button
                                                    type="button"
                                                    variant="danger-ghost"
                                                    size="sm"
                                                    wire:click="removeEquipment({{ $equipment['id'] }})"
                                                    aria-label="Remove {{ $equipment['brand'] }} {{ $equipment['model'] }} from selection"
                                                >
                                                    <x-myds.icon name="trash" />
                                                </x-myds.button>
                                            </div>
                                        </div>
                                    </x-myds.card-body>
                                </x-myds.card>
                            @endforeach
                        </div>
                    </div>
                @else
                    @error('selectedEquipment')
                        <x-myds.callout variant="warning">
                            <x-myds.icon name="exclamation-triangle" class="w-5 h-5" />
                            {{ $message }}
                        </x-myds.callout>
                    @enderror
                @endif
            </x-myds.card-body>
        </x-myds.card>

        {{-- Form Actions --}}
        <x-myds.card>
            <x-myds.card-body>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="text-body-sm text-txt-black-600">
                        <x-myds.icon name="information-circle" class="mr-1" />
                        Permohonan akan dihantar kepada penyelia untuk kelulusan.<br class="sm:hidden">
                        <span class="text-txt-black-500">Request will be sent to supervisor for approval.</span>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <x-myds.button
                            :href="route('loan.index')"
                            variant="secondary"
                        >
                            <x-myds.button-icon>
                                <x-myds.icon name="arrow-left" />
                            </x-myds.button-icon>
                            Batal / Cancel
                        </x-myds.button>
                        <x-myds.button
                            type="submit"
                            variant="primary"
                            wire:loading.attr="disabled"
                            wire:target="submit"
                        >
                            <span wire:loading.remove wire:target="submit">
                                <x-myds.button-icon>
                                    <x-myds.icon name="paper-airplane" />
                                </x-myds.button-icon>
                                Hantar Permohonan / Submit Request
                            </span>
                            <span wire:loading wire:target="submit" class="flex items-center">
                                <x-myds.spinner color="white" size="small" class="mr-2" />
                                Menghantar...
                            </span>
                        </x-myds.button>
                    </div>
                </div>
            </x-myds.card-body>
        </x-myds.card>
    </form>

    {{-- Equipment Selection Modal --}}
    @if($showEquipmentModal)
        <x-myds.modal open>
            <x-myds.modal-header>
                <x-myds.icon name="desktop-computer" class="w-5 h-5 mr-2" />
                Pilih Peralatan / Select Equipment
                <x-myds.button type="button" variant="tertiary" size="sm" class="ml-auto" wire:click="closeEquipmentModal" aria-label="Close modal">
                    <x-myds.icon name="x" />
                </x-myds.button>
            </x-myds.modal-header>
            <x-myds.modal-body>
                @if(count($availableEquipment) > 0)
                    <div class="space-y-3">
                        @foreach($availableEquipment as $equipment)
                            <x-myds.card variant="bordered" class="hover:bg-washed transition">
                                <x-myds.card-body class="p-4">
                                    <div class="flex items-start gap-4">
                                        <x-myds.checkbox
                                            id="equipment-{{ $equipment['id'] }}"
                                            wire:click="toggleEquipment({{ $equipment['id'] }})"
                                            :checked="in_array($equipment['id'], $selectedEquipment)"
                                            class="mt-1"
                                        />
                                        <label for="equipment-{{ $equipment['id'] }}" class="flex-1 cursor-pointer">
                                            <div class="text-body-md font-semibold text-txt-black-900">
                                                {{ $equipment['brand'] }} {{ $equipment['model'] }}
                                            </div>
                                            <div class="text-body-sm text-txt-black-600">
                                                {{ $equipment['asset_tag'] }}
                                                @if(!empty($equipment['serial_number']))
                                                    • S/N: {{ $equipment['serial_number'] }}
                                                @endif
                                            </div>
                                            @if(!empty($equipment['specifications']))
                                                <div class="text-body-sm text-txt-black-500 mt-1">
                                                    {{ $equipment['specifications'] }}
                                                </div>
                                            @endif
                                            @if(!empty($equipment['location']))
                                                <div class="text-body-sm text-txt-black-400 mt-1">
                                                    <x-myds.icon name="location-marker" class="mr-1" />
                                                    {{ $equipment['location'] }}
                                                </div>
                                            @endif
                                        </label>
                                        <x-myds.badge variant="success">
                                            {{ ucfirst($equipment['status']) }}
                                        </x-myds.badge>
                                    </div>
                                </x-myds.card-body>
                            </x-myds.card>
                        @endforeach
                    </div>
                @else
                    <x-myds.callout variant="info" class="text-center py-8">
                        <x-myds.icon name="desktop-computer" class="text-txt-black-400 text-4xl mb-4" />
                        <div class="myds-heading-md text-txt-black-900 mb-2">
                            Tiada Peralatan Tersedia
                        </div>
                        <div class="text-body-md text-txt-black-600">
                            No equipment available in this category at the moment.
                        </div>
                    </x-myds.callout>
                @endif
            </x-myds.modal-body>
            <x-myds.modal-footer>
                <x-myds.button type="button" variant="primary" wire:click="closeEquipmentModal">
                    <x-myds.icon name="check" class="mr-2" />
                    Selesai / Done
                    @if(count($selectedEquipment) > 0)
                        <x-myds.badge variant="white" class="ml-2">{{ count($selectedEquipment) }}</x-myds.badge>
                    @endif
                </x-myds.button>
            </x-myds.modal-footer>
        </x-myds.modal>
    @endif
</main>

<x-myds.footer>
    <x-myds.footer-section>
        <x-myds.site-info>
            <x-myds.footer-logo logoTitle="Bahagian Pengurusan Maklumat (BPM)" />
            Aras 13, 14 &amp; 15, Blok Menara, Menara Usahawan, No. 18, Persiaran Perdana, Presint 2, 62000 Putrajaya, Malaysia
            <div class="mt-2">© 2025 BPM, Kementerian Pelancongan, Seni dan Budaya Malaysia.</div>
            <div class="mt-2 flex gap-3">
                <a href="#" aria-label="Facebook" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="facebook" class="w-5 h-5" /></a>
                <a href="#" aria-label="Twitter" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="twitter" class="w-5 h-5" /></a>
                <a href="#" aria-label="Instagram" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="instagram" class="w-5 h-5" /></a>
                <a href="#" aria-label="YouTube" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="youtube" class="w-5 h-5" /></a>
            </div>
        </x-myds.site-info>
    </x-myds.footer-section>
</x-myds.footer>

{{-- Enhanced UX: focus modal, enforce date constraints --}}
<script>
    document.addEventListener('alpine:init', () => {
        Livewire.on('modal-opened', () => {
            setTimeout(() => {
                const modal = document.querySelector('.myds-modal-open');
                if (modal) {
                    const firstInput = modal.querySelector('input:not([type="hidden"]), select, textarea');
                    if (firstInput) firstInput.focus();
                }
            }, 100);
        });
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
