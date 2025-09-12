<!-- Loan Request Form - ICT Serve (iServe) -->
<div class="myds-container">
    <!-- MYDS Breadcrumb -->
    <nav aria-label="Breadcrumb" class="myds-breadcrumb mb-6">
        <ol class="myds-breadcrumb-list">
            @foreach($breadcrumbs as $index => $breadcrumb)
                <li class="myds-breadcrumb-item">
                    @if(isset($breadcrumb['url']) && !$loop->last)
                        <a href="{{ $breadcrumb['url'] }}" class="myds-breadcrumb-link">
                            {{ $breadcrumb['title'] }}
                        </a>
                    @else
                        <span class="myds-breadcrumb-current" aria-current="page">
                            {{ $breadcrumb['title'] }}
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>

    <!-- Page Header -->
    <header class="myds-page-header mb-8">
        <div class="myds-page-header-content">
            <h1 class="myds-heading-xl text-myds-primary-700 dark:text-myds-primary-300">
                <i class="myds-icon-laptop mr-3" aria-hidden="true"></i>
                Mohon Pinjaman Peralatan ICT
            </h1>
            <p class="myds-text-body-md text-myds-gray-600 dark:text-myds-gray-400 mt-2">
                Request for ICT Equipment Loan
            </p>
            <p class="myds-text-body-sm text-myds-gray-500 dark:text-myds-gray-500 mt-1">
                Sila lengkapkan borang di bawah untuk mohon pinjaman peralatan ICT.
                <br class="sm:hidden">
                <span class="text-myds-gray-400">Please complete the form below to request ICT equipment loan.</span>
            </p>
        </div>
    </header>

    <!-- Alert Messages -->
    @if (session()->has('message'))
        <div class="myds-alert myds-alert-success mb-6" role="alert">
            <div class="myds-alert-icon">
                <i class="myds-icon-check-circle" aria-hidden="true"></i>
            </div>
            <div class="myds-alert-content">
                <h3 class="myds-alert-title">Berjaya / Success</h3>
                <p class="myds-alert-description">{{ session('message') }}</p>
            </div>
        </div>
    @endif

    @if ($errors->has('form'))
        <div class="myds-alert myds-alert-error mb-6" role="alert">
            <div class="myds-alert-icon">
                <i class="myds-icon-x-circle" aria-hidden="true"></i>
            </div>
            <div class="myds-alert-content">
                <h3 class="myds-alert-title">Ralat / Error</h3>
                <p class="myds-alert-description">{{ $errors->first('form') }}</p>
            </div>
        </div>
    @endif

    <!-- Main Form -->
    <form wire:submit="submit" class="myds-form space-y-8">
        @csrf

        <!-- Request Details Section -->
        <div class="myds-card myds-card-elevated">
            <div class="myds-card-header">
                <h2 class="myds-heading-lg text-myds-gray-900 dark:text-myds-gray-100">
                    <i class="myds-icon-document-text mr-2" aria-hidden="true"></i>
                    Butiran Permohonan / Request Details
                </h2>
            </div>

            <div class="myds-card-body">
                <div class="myds-grid myds-grid-cols-1 lg:myds-grid-cols-2 myds-gap-6">
                    <!-- Purpose -->
                    <div class="lg:myds-col-span-2">
                        <label for="purpose" class="myds-label myds-label-required">
                            Tujuan Pinjaman / Purpose of Loan
                        </label>
                        <textarea
                            id="purpose"
                            wire:model="purpose"
                            class="myds-textarea @error('purpose') myds-input-error @enderror"
                            rows="3"
                            placeholder="Nyatakan tujuan penggunaan peralatan ICT... / State the purpose of ICT equipment usage..."
                            aria-describedby="purpose-help @error('purpose') purpose-error @enderror"
                            required
                            maxlength="500"
                        ></textarea>
                        <p id="purpose-help" class="myds-help-text">
                            Berikan penerangan yang jelas untuk memudahkan proses kelulusan.
                            <span class="text-myds-gray-400">Provide clear explanation to facilitate approval process.</span>
                        </p>
                        @error('purpose')
                            <p id="purpose-error" class="myds-error-text" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date From -->
                    <div>
                        <label for="requested_from" class="myds-label myds-label-required">
                            Tarikh Mula / Start Date
                        </label>
                        <input
                            type="date"
                            id="requested_from"
                            wire:model="requested_from"
                            class="myds-input @error('requested_from') myds-input-error @enderror"
                            required
                            min="{{ now()->addDay()->format('Y-m-d') }}"
                            aria-describedby="@error('requested_from') date-from-error @enderror"
                        />
                        @error('requested_from')
                            <p id="date-from-error" class="myds-error-text" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date To -->
                    <div>
                        <label for="requested_to" class="myds-label myds-label-required">
                            Tarikh Tamat / End Date
                        </label>
                        <input
                            type="date"
                            id="requested_to"
                            wire:model="requested_to"
                            class="myds-input @error('requested_to') myds-input-error @enderror"
                            required
                            min="{{ $requested_from ?: now()->addDay()->format('Y-m-d') }}"
                            aria-describedby="@error('requested_to') date-to-error @enderror"
                        />
                        @error('requested_to')
                            <p id="date-to-error" class="myds-error-text" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact Phone -->
                    <div>
                        <label for="contact_phone" class="myds-label">
                            No. Telefon Perhubungan / Contact Phone
                        </label>
                        <input
                            type="tel"
                            id="contact_phone"
                            wire:model="contact_phone"
                            class="myds-input @error('contact_phone') myds-input-error @enderror"
                            placeholder="012-3456789"
                            maxlength="20"
                            aria-describedby="phone-help @error('contact_phone') phone-error @enderror"
                        />
                        <p id="phone-help" class="myds-help-text">
                            Untuk dihubungi jika diperlukan. / For contact if necessary.
                        </p>
                        @error('contact_phone')
                            <p id="phone-error" class="myds-error-text" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Additional Notes -->
                    <div>
                        <label for="notes" class="myds-label">
                            Catatan Tambahan / Additional Notes
                        </label>
                        <textarea
                            id="notes"
                            wire:model="notes"
                            class="myds-textarea @error('notes') myds-input-error @enderror"
                            rows="3"
                            placeholder="Catatan atau keperluan khas... / Additional notes or special requirements..."
                            maxlength="1000"
                            aria-describedby="@error('notes') notes-error @enderror"
                        ></textarea>
                        @error('notes')
                            <p id="notes-error" class="myds-error-text" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipment Selection Section -->
        <div class="myds-card myds-card-elevated">
            <div class="myds-card-header">
                <h2 class="myds-heading-lg text-myds-gray-900 dark:text-myds-gray-100">
                    <i class="myds-icon-desktop-computer mr-2" aria-hidden="true"></i>
                    Pemilihan Peralatan / Equipment Selection
                </h2>
            </div>

            <div class="myds-card-body">
                <!-- Equipment Categories -->
                @if(count($equipmentCategories) > 0)
                    <div class="mb-6">
                        <h3 class="myds-heading-md text-myds-gray-800 dark:text-myds-gray-200 mb-4">
                            Kategori Peralatan / Equipment Categories
                        </h3>
                        <div class="myds-grid myds-grid-cols-1 sm:myds-grid-cols-2 lg:myds-grid-cols-3 myds-gap-4">
                            @foreach($equipmentCategories as $category)
                                <button
                                    type="button"
                                    wire:click="loadEquipmentByCategory({{ $category['id'] }})"
                                    class="myds-button myds-button-secondary myds-button-block text-left p-4 h-auto"
                                >
                                    <div class="flex items-start space-x-3">
                                        <i class="myds-icon-{{ $category['icon'] ?? 'desktop-computer' }} text-myds-primary-600 mt-1" aria-hidden="true"></i>
                                        <div>
                                            <div class="myds-text-body-md font-semibold text-myds-gray-900 dark:text-myds-gray-100">
                                                {{ $category['name'] }}
                                            </div>
                                            @if(!empty($category['description']))
                                                <div class="myds-text-body-sm text-myds-gray-600 dark:text-myds-gray-400 mt-1">
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
                    <div class="myds-empty-state text-center py-12">
                        <i class="myds-icon-exclamation-triangle text-myds-yellow-500 text-4xl mb-4" aria-hidden="true"></i>
                        <h3 class="myds-heading-md text-myds-gray-900 dark:text-myds-gray-100 mb-2">
                            Tiada Kategori Peralatan
                        </h3>
                        <p class="myds-text-body-md text-myds-gray-600 dark:text-myds-gray-400">
                            No equipment categories available at the moment.
                        </p>
                    </div>
                @endif

                <!-- Selected Equipment -->
                @if(count($this->selectedEquipmentDetails) > 0)
                    <div class="border-t border-myds-gray-200 dark:border-myds-gray-700 pt-6">
                        <h3 class="myds-heading-md text-myds-gray-800 dark:text-myds-gray-200 mb-4">
                            Peralatan Dipilih / Selected Equipment
                            <span class="myds-badge myds-badge-primary ml-2">{{ count($selectedEquipment) }}</span>
                        </h3>

                        <div class="space-y-3">
                            @foreach($this->selectedEquipmentDetails as $equipment)
                                <div class="myds-card myds-card-bordered">
                                    <div class="myds-card-body p-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <div class="myds-text-body-md font-semibold text-myds-gray-900 dark:text-myds-gray-100">
                                                    {{ $equipment['brand'] }} {{ $equipment['model'] }}
                                                </div>
                                                <div class="myds-text-body-sm text-myds-gray-600 dark:text-myds-gray-400">
                                                    {{ $equipment['category']['name'] ?? 'N/A' }} • {{ $equipment['asset_tag'] }}
                                                </div>
                                                @if(!empty($equipment['specifications']))
                                                    <div class="myds-text-body-sm text-myds-gray-500 dark:text-myds-gray-500 mt-1">
                                                        {{ $equipment['specifications'] }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="flex items-center space-x-3 ml-4">
                                                <!-- Quantity Input -->
                                                <div class="flex items-center space-x-2">
                                                    <label for="qty-{{ $equipment['id'] }}" class="myds-text-body-sm text-myds-gray-600 dark:text-myds-gray-400">
                                                        Kuantiti:
                                                    </label>
                                                    <input
                                                        type="number"
                                                        id="qty-{{ $equipment['id'] }}"
                                                        wire:model="equipmentQuantities.{{ $equipment['id'] }}"
                                                        class="myds-input w-16 text-center"
                                                        min="1"
                                                        max="10"
                                                        aria-label="Quantity for {{ $equipment['brand'] }} {{ $equipment['model'] }}"
                                                    />
                                                </div>

                                                <!-- Remove Button -->
                                                <button
                                                    type="button"
                                                    wire:click="removeEquipment({{ $equipment['id'] }})"
                                                    class="myds-button myds-button-danger-ghost myds-button-sm"
                                                    aria-label="Remove {{ $equipment['brand'] }} {{ $equipment['model'] }} from selection"
                                                >
                                                    <i class="myds-icon-trash" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    @error('selectedEquipment')
                        <div class="myds-alert myds-alert-warning" role="alert">
                            <div class="myds-alert-icon">
                                <i class="myds-icon-exclamation-triangle" aria-hidden="true"></i>
                            </div>
                            <div class="myds-alert-content">
                                <p class="myds-alert-description">{{ $message }}</p>
                            </div>
                        </div>
                    @enderror
                @endif
            </div>
        </div>

        <!-- Form Actions -->
        <div class="myds-card myds-card-elevated">
            <div class="myds-card-body">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="myds-text-body-sm text-myds-gray-600 dark:text-myds-gray-400">
                        <i class="myds-icon-information-circle mr-1" aria-hidden="true"></i>
                        Permohonan akan dihantar kepada penyelia untuk kelulusan.
                        <br class="sm:hidden">
                        <span class="text-myds-gray-500">Request will be sent to supervisor for approval.</span>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <a
                            href="{{ route('loan.index') }}"
                            class="myds-button myds-button-secondary"
                            wire:navigate
                        >
                            <i class="myds-icon-arrow-left mr-2" aria-hidden="true"></i>
                            Batal / Cancel
                        </a>

                        <button
                            type="submit"
                            class="myds-button myds-button-primary"
                            wire:loading.attr="disabled"
                            wire:target="submit"
                        >
                            <span wire:loading.remove wire:target="submit">
                                <i class="myds-icon-paper-airplane mr-2" aria-hidden="true"></i>
                                Hantar Permohonan / Submit Request
                            </span>
                            <span wire:loading wire:target="submit" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Menghantar...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Equipment Selection Modal -->
    @if($showEquipmentModal)
        <div class="myds-modal myds-modal-open" role="dialog" aria-modal="true" aria-labelledby="modal-title">
            <div class="myds-modal-backdrop" wire:click="closeEquipmentModal"></div>
            <div class="myds-modal-content myds-modal-lg">
                <div class="myds-modal-header">
                    <h3 id="modal-title" class="myds-modal-title">
                        <i class="myds-icon-desktop-computer mr-2" aria-hidden="true"></i>
                        Pilih Peralatan / Select Equipment
                    </h3>
                    <button
                        type="button"
                        wire:click="closeEquipmentModal"
                        class="myds-modal-close"
                        aria-label="Close modal"
                    >
                        <i class="myds-icon-x" aria-hidden="true"></i>
                    </button>
                </div>

                <div class="myds-modal-body">
                    @if(count($availableEquipment) > 0)
                        <div class="space-y-3">
                            @foreach($availableEquipment as $equipment)
                                <div class="myds-card myds-card-bordered hover:myds-card-hover transition-colors">
                                    <div class="myds-card-body p-4">
                                        <div class="flex items-start space-x-4">
                                            <input
                                                type="checkbox"
                                                id="equipment-{{ $equipment['id'] }}"
                                                class="myds-checkbox mt-1"
                                                wire:click="toggleEquipment({{ $equipment['id'] }})"
                                                @if(in_array($equipment['id'], $selectedEquipment)) checked @endif
                                            />

                                            <label for="equipment-{{ $equipment['id'] }}" class="flex-1 cursor-pointer">
                                                <div class="myds-text-body-md font-semibold text-myds-gray-900 dark:text-myds-gray-100">
                                                    {{ $equipment['brand'] }} {{ $equipment['model'] }}
                                                </div>
                                                <div class="myds-text-body-sm text-myds-gray-600 dark:text-myds-gray-400">
                                                    {{ $equipment['asset_tag'] }}
                                                    @if(!empty($equipment['serial_number']))
                                                        • S/N: {{ $equipment['serial_number'] }}
                                                    @endif
                                                </div>
                                                @if(!empty($equipment['specifications']))
                                                    <div class="myds-text-body-sm text-myds-gray-500 dark:text-myds-gray-500 mt-1">
                                                        {{ $equipment['specifications'] }}
                                                    </div>
                                                @endif
                                                @if(!empty($equipment['location']))
                                                    <div class="myds-text-body-sm text-myds-gray-400 dark:text-myds-gray-600 mt-1">
                                                        <i class="myds-icon-location-marker mr-1" aria-hidden="true"></i>
                                                        {{ $equipment['location'] }}
                                                    </div>
                                                @endif
                                            </label>

                                            <div class="myds-badge myds-badge-success">
                                                {{ ucfirst($equipment['status']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="myds-empty-state text-center py-8">
                            <i class="myds-icon-desktop-computer text-myds-gray-400 text-4xl mb-4" aria-hidden="true"></i>
                            <h3 class="myds-heading-md text-myds-gray-900 dark:text-myds-gray-100 mb-2">
                                Tiada Peralatan Tersedia
                            </h3>
                            <p class="myds-text-body-md text-myds-gray-600 dark:text-myds-gray-400">
                                No equipment available in this category at the moment.
                            </p>
                        </div>
                    @endif
                </div>

                <div class="myds-modal-footer">
                    <button
                        type="button"
                        wire:click="closeEquipmentModal"
                        class="myds-button myds-button-primary"
                    >
                        <i class="myds-icon-check mr-2" aria-hidden="true"></i>
                        Selesai / Done
                        @if(count($selectedEquipment) > 0)
                            <span class="myds-badge myds-badge-white ml-2">{{ count($selectedEquipment) }}</span>
                        @endif
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Add JavaScript for enhanced UX -->
<script>
    document.addEventListener('alpine:init', () => {
        // Auto-focus on modal open
        Livewire.on('modal-opened', () => {
            setTimeout(() => {
                const modal = document.querySelector('.myds-modal-open');
                if (modal) {
                    const firstInput = modal.querySelector('input:not([type="hidden"]), select, textarea');
                    if (firstInput) firstInput.focus();
                }
            }, 100);
        });

        // Date validation
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
