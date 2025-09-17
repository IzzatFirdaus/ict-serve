@php
    $title = 'Borang Permohonan Peminjaman Peralatan ICT';
@endphp

<x-layouts.app :title="$title">
    <div class="myds-container max-w-6xl mx-auto py-8">
        <!-- Page Header -->
        <header class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="font-heading text-heading-m font-semibold text-txt-black-900 dark:text-txt-black-900 mb-2">
                        Borang Permohonan Peminjaman Peralatan ICT
                    </h1>
                    <h2 class="font-heading text-heading-2xs font-medium text-txt-black-700 dark:text-txt-black-700">
                        ICT Equipment Loan Application Form for Official Use
                    </h2>
                    <p class="text-body-sm text-txt-black-500 dark:text-txt-black-500 mt-1">
                        Bahagian Pengurusan Maklumat (BPM) - Information Management Division
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <x-myds.tag variant="primary">
                        {{ $formReference }}
                    </x-myds.tag>
                    <x-myds.tag variant="info">
                        MYDS Compliant
                    </x-myds.tag>
                </div>
            </div>

            <x-myds.callout variant="info">
                <h3 class="font-medium text-txt-black-900 dark:text-txt-black-900 mb-2">Syarat-syarat Peminjaman</h3>
                <ul class="text-body-sm space-y-1 text-txt-black-700 dark:text-txt-black-700">
                    <li>• Borang mestilah diisi lengkap, terutamanya medan yang bertanda <span class="text-danger-600 dark:text-danger-400 font-medium">*</span></li>
                    <li>• Permohonan tertakluk kepada ketersediaan peralatan atas dasar 'Siapa Cepat, Dia Dapat'</li>
                    <li>• Permohonan akan diproses dalam tempoh tiga (3) hari bekerja selepas menerima borang lengkap</li>
                    <li>• Pemohon bertanggungjawab sepenuhnya ke atas sebarang kehilangan atau kerosakan</li>
                </ul>
            </x-myds.callout>
        </header>

        <!-- Loan Application Form -->
        <form wire:submit="submit"
              class="space-y-8"
              novalidate
              aria-label="Borang Permohonan Peminjaman Peralatan ICT"
              x-data="{
                  currentStep: 1,
                  totalSteps: 5,
                  sameAsApplicant: @entangle('sameAsApplicant'),
                  isSubmitting: false
              }">

            <!-- Progress Indicator -->
            <div class="relative mb-8">
                <div class="overflow-hidden h-2 text-xs flex rounded-full bg-bg-washed dark:bg-bg-washed">
                    <div class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-primary-600 transition-all duration-500"
                         :style="`width: ${(currentStep / totalSteps) * 100}%`"></div>
                </div>
                <div class="flex justify-between text-body-xs text-txt-black-500 dark:text-txt-black-500 mt-2">
                    <span>Pemohon</span>
                    <span>Pegawai</span>
                    <span>Peralatan</span>
                    <span>Sokongan</span>
                    <span>Semak</span>
                </div>
            </div>

            <!-- Step 1: Applicant Information -->
            <x-myds.panel variant="default" x-show="currentStep === 1">
                <h2 class="font-heading text-heading-s font-medium text-txt-black-900 dark:text-txt-black-900 mb-6 flex items-center">
                    <span class="bg-primary-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-body-sm font-medium mr-3">1</span>
                    Maklumat Pemohon
                </h2>

                <div class="space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <x-myds.input
                            name="applicant_name"
                            label="Nama Penuh"
                            wire:model.blur="applicant_name"
                            required
                            placeholder="Contoh: Ahmad bin Ali"
                            autocomplete="name"
                        />
                        <x-myds.input
                            name="applicant_position"
                            label="Jawatan & Gred"
                            wire:model.blur="applicant_position"
                            required
                            placeholder="Contoh: Penolong Pegawai Tadbir N29"
                        />
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <x-myds.select
                            name="applicant_department"
                            label="Bahagian/Unit"
                            wire:model.live="applicant_department"
                            required
                            :options="$departments"
                        />
                        <x-myds.input
                            name="applicant_phone"
                            label="No. Telefon"
                            type="tel"
                            wire:model.blur="applicant_phone"
                            required
                            placeholder="Contoh: 03-1234567"
                            autocomplete="tel"
                        />
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <x-myds.textarea
                            name="purpose"
                            label="Tujuan Permohonan"
                            wire:model.blur="purpose"
                            required
                            placeholder="Nyatakan tujuan peminjaman peralatan ICT..."
                            :maxlength="500"
                        />
                        <x-myds.input
                            name="location"
                            label="Lokasi"
                            wire:model.blur="location"
                            required
                            placeholder="Contoh: Dewan Utama, Tingkat 3"
                        />
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <x-myds.input
                            name="loan_start_date"
                            label="Tarikh Pinjaman"
                            type="date"
                            wire:model.live="loan_start_date"
                            required
                            :min="date('Y-m-d')"
                        />
                        <x-myds.input
                            name="expected_return_date"
                            label="Tarikh Dijangka Pulang"
                            type="date"
                            wire:model.live="expected_return_date"
                            required
                            :min="$loan_start_date ?: date('Y-m-d')"
                        />
                    </div>
                </div>

                <div class="flex justify-end mt-8">
                    <x-myds.button
                        type="button"
                        variant="primary"
                        @click="currentStep = 2"
                        :disabled="!$this->canProceedToStep2"
                    >
                        Seterusnya
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </x-myds.button>
                </div>
            </x-myds.panel>

            <!-- Step 2: Responsible Officer Information -->
            <x-myds.panel variant="default" x-show="currentStep === 2">
                <h2 class="font-heading text-heading-s font-medium text-txt-black-900 dark:text-txt-black-900 mb-6 flex items-center">
                    <span class="bg-primary-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-body-sm font-medium mr-3">2</span>
                    Maklumat Pegawai Bertanggungjawab
                </h2>

                <div class="mb-6 p-4 bg-primary-25 dark:bg-primary-25 border border-primary-200 dark:border-primary-200 rounded-radius-m">
                    <div class="flex items-center space-x-3">
                        <input type="checkbox"
                               id="same_as_applicant"
                               wire:model.live="sameAsApplicant"
                               class="h-4 w-4 text-primary-600 focus:ring-fr-primary border-otl-gray-300 rounded">
                        <label for="same_as_applicant" class="text-body-sm font-medium text-txt-black-900 dark:text-txt-black-900">
                            Pemohon adalah sama dengan Pegawai Bertanggungjawab
                        </label>
                    </div>
                    <p class="text-body-xs text-txt-black-600 dark:text-txt-black-600 mt-2">
                        Tandakan jika anda akan bertanggungjawab sendiri terhadap peralatan yang dipinjam.
                    </p>
                </div>

                <div class="space-y-6" x-show="!sameAsApplicant">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <x-myds.input
                            name="responsible_officer_name"
                            label="Nama Penuh Pegawai Bertanggungjawab"
                            wire:model.blur="responsible_officer_name"
                            :required="!$sameAsApplicant"
                            placeholder="Contoh: Fatimah binti Ahmad"
                        />
                        <x-myds.input
                            name="responsible_officer_position"
                            label="Jawatan & Gred"
                            wire:model.blur="responsible_officer_position"
                            :required="!$sameAsApplicant"
                            placeholder="Contoh: Pegawai Tadbir N41"
                        />
                    </div>
                    <x-myds.input
                        name="responsible_officer_phone"
                        label="No. Telefon"
                        type="tel"
                        wire:model.blur="responsible_officer_phone"
                        :required="!$sameAsApplicant"
                        placeholder="Contoh: 03-1234567"
                    />
                </div>

                <div class="flex justify-between mt-8">
                    <x-myds.button
                        type="button"
                        variant="secondary"
                        @click="currentStep = 1"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali
                    </x-myds.button>
                    <x-myds.button
                        type="button"
                        variant="primary"
                        @click="currentStep = 3"
                        :disabled="!$this->canProceedToStep3"
                    >
                        Seterusnya
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </x-myds.button>
                </div>
            </x-myds.panel>

            <!-- Step 3: Equipment Information -->
            <x-myds.panel variant="default" x-show="currentStep === 3">
                <h2 class="font-heading text-heading-s font-medium text-txt-black-900 dark:text-txt-black-900 mb-6 flex items-center">
                    <span class="bg-primary-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-body-sm font-medium mr-3">3</span>
                    Maklumat Peralatan
                </h2>
                <div class="space-y-6">
                    <!-- Equipment Request Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-otl-gray-200 dark:border-otl-gray-200 rounded-radius-m">
                            <thead>
                                <tr class="bg-bg-washed dark:bg-bg-washed">
                                    <th class="px-4 py-3 text-left text-body-xs font-medium text-txt-black-900 dark:text-txt-black-900">Bil.</th>
                                    <th class="px-4 py-3 text-left text-body-xs font-medium text-txt-black-900 dark:text-txt-black-900">Jenis Peralatan *</th>
                                    <th class="px-4 py-3 text-left text-body-xs font-medium text-txt-black-900 dark:text-txt-black-900">Kuantiti *</th>
                                    <th class="px-4 py-3 text-left text-body-xs font-medium text-txt-black-900 dark:text-txt-black-900">Catatan</th>
                                    <th class="px-4 py-3 text-center text-body-xs font-medium text-txt-black-900 dark:text-txt-black-900">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-otl-gray-200 dark:divide-otl-gray-200">
                                @foreach($equipmentRequests as $index => $request)
                                    <tr class="hover:bg-bg-white-50 dark:hover:bg-bg-white-50 transition-colors">
                                        <td class="px-4 py-3 text-body-sm text-txt-black-900 dark:text-txt-black-900">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3">
                                            <select wire:model.live="equipmentRequests.{{ $index }}.equipment_type"
                                                    class="myds-input w-full @error('equipmentRequests.'.$index.'.equipment_type') myds-input-error @enderror"
                                                    required>
                                                <option value="">Pilih jenis peralatan</option>
                                                @foreach($equipmentTypes as $value => $label)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                            @error('equipmentRequests.'.$index.'.equipment_type')
                                                <div class="myds-field-error" role="alert">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="number"
                                                   wire:model.blur="equipmentRequests.{{ $index }}.quantity"
                                                   class="myds-input w-24 @error('equipmentRequests.'.$index.'.quantity') myds-input-error @enderror"
                                                   min="1"
                                                   max="10"
                                                   required>
                                            @error('equipmentRequests.'.$index.'.quantity')
                                                <div class="myds-field-error" role="alert">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="text"
                                                   wire:model.blur="equipmentRequests.{{ $index }}.notes"
                                                   class="myds-input w-full"
                                                   placeholder="Catatan tambahan...">
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            @if(count($equipmentRequests) > 1)
                                                <button type="button"
                                                        wire:click="removeEquipmentRow({{ $index }})"
                                                        class="text-danger-600 hover:text-danger-700 dark:text-danger-600 dark:hover:text-danger-700 p-1 focus:outline-none focus:ring-2 focus:ring-fr-danger rounded"
                                                        title="Buang baris">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Add Equipment Button -->
                    @if(count($equipmentRequests) < 10)
                        <div class="flex justify-center">
                            <x-myds.button
                                type="button"
                                variant="secondary"
                                wire:click="addEquipmentRow"
                                size="sm"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Peralatan
                            </x-myds.button>
                        </div>
                    @endif

                    @if(count($equipmentRequests) >= 10)
                        <x-myds.callout variant="warning">
                            <p class="text-body-sm">
                                Maksimum 10 jenis peralatan sahaja boleh dipohon dalam satu permohonan.
                                Jika memerlukan lebih banyak peralatan, sila buat permohonan berasingan.
                            </p>
                        </x-myds.callout>
                    @endif
                </div>

                <div class="flex justify-between mt-8">
                    <x-myds.button
                        type="button"
                        variant="secondary"
                        @click="currentStep = 2"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali
                    </x-myds.button>
                    <x-myds.button
                        type="button"
                        variant="primary"
                        @click="currentStep = 4"
                        :disabled="!$this->canProceedToStep4"
                    >
                        Seterusnya
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </x-myds.button>
                </div>
            </x-myds.panel>

            <!-- Step 4: Division Endorsement -->
            <x-myds.panel variant="warning" x-show="currentStep === 4">
                <h2 class="font-heading text-heading-s font-medium text-txt-black-900 dark:text-txt-black-900 mb-6 flex items-center">
                    <span class="bg-warning-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-body-sm font-medium mr-3">4</span>
                    Sokongan dari Bahagian/Unit/Seksyen
                </h2>

                <div class="space-y-6">
                    <x-myds.callout variant="info">
                        <h3 class="font-medium text-txt-black-900 dark:text-txt-black-900 mb-2">Keperluan Sokongan</h3>
                        <p class="text-body-sm text-txt-black-700 dark:text-txt-black-700">
                            Permohonan mesti disokong oleh pegawai yang bergred sekurang-kurangnya Gred 41.
                            Sokongan ini menunjukkan bahawa permohonan telah diluluskan oleh pihak atasan dan adalah untuk kegunaan rasmi.
                        </p>
                    </x-myds.callout>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <x-myds.input
                            name="endorsing_officer_name"
                            label="Nama Pegawai Penyokong"
                            wire:model.blur="endorsing_officer_name"
                            required
                            placeholder="Nama pegawai yang menyokong permohonan"
                        />
                        <x-myds.input
                            name="endorsing_officer_position"
                            label="Jawatan & Gred"
                            wire:model.blur="endorsing_officer_position"
                            required
                            placeholder="Contoh: Pegawai Tadbir N48"
                        />
                    </div>

                    <div>
                        <label class="myds-label">Status Sokongan *</label>
                        <div class="mt-2 space-y-2">
                            <div class="flex items-center space-x-3">
                                <input type="radio"
                                       id="endorsed_yes"
                                       value="supported"
                                       wire:model.live="endorsement_status"
                                       class="h-4 w-4 text-success-600 focus:ring-fr-success border-otl-gray-300">
                                <label for="endorsed_yes" class="text-body-sm text-txt-black-900 dark:text-txt-black-900 font-medium">
                                    DISOKONG
                                </label>
                            </div>
                            <div class="flex items-center space-x-3">
                                <input type="radio"
                                       id="endorsed_no"
                                       value="not_supported"
                                       wire:model.live="endorsement_status"
                                       class="h-4 w-4 text-danger-600 focus:ring-fr-danger border-otl-gray-300">
                                <label for="endorsed_no" class="text-body-sm text-txt-black-900 dark:text-txt-black-900 font-medium">
                                    TIDAK DISOKONG
                                </label>
                            </div>
                        </div>
                        @error('endorsement_status')
                            <div class="myds-field-error" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                    @if($endorsement_status === 'not_supported')
                        <x-myds.textarea
                            name="endorsement_comments"
                            label="Komen/Sebab Tidak Disokong"
                            wire:model.blur="endorsement_comments"
                            placeholder="Nyatakan sebab mengapa permohonan tidak disokong..."
                            :maxlength="500"
                        />
                    @endif

                    <div class="bg-warning-25 dark:bg-warning-25 border border-warning-200 dark:border-warning-200 rounded-radius-m p-6">
                        <h3 class="font-medium text-txt-black-900 dark:text-txt-black-900 mb-3">Perakuan Pegawai Penyokong</h3>
                        <div class="prose prose-sm text-txt-black-700 dark:text-txt-black-700 max-w-none text-body-sm">
                            <p>Saya dengan ini mengesahkan bahawa permohonan peminjaman peralatan ICT ini adalah untuk kegunaan rasmi dan saya menyokong permohonan ini.</p>
                        </div>
                        <div class="flex items-start space-x-3 mt-4">
                            <input type="checkbox"
                                   id="endorsement_confirmation"
                                   wire:model.live="endorsement_confirmation"
                                   class="mt-1 h-4 w-4 text-warning-600 focus:ring-fr-warning border-otl-gray-300 rounded">
                            <label for="endorsement_confirmation" class="text-body-sm text-txt-black-900 dark:text-txt-black-900 font-medium">
                                Saya mengesahkan sokongan ini sebagai pegawai yang bertanggungjawab. *
                            </label>
                        </div>
                        @error('endorsement_confirmation')
                            <div class="myds-field-error" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-between mt-8">
                    <x-myds.button
                        type="button"
                        variant="secondary"
                        @click="currentStep = 3"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali
                    </x-myds.button>
                    <x-myds.button
                        type="button"
                        variant="primary"
                        @click="currentStep = 5"
                        :disabled="!$this->canProceedToStep5"
                    >
                        Semak Permohonan
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </x-myds.button>
                </div>
            </x-myds.panel>

            <!-- Step 5: Review and Submit -->
            <x-myds.panel variant="success" x-show="currentStep === 5">
                <h2 class="font-heading text-heading-s font-medium text-txt-black-900 dark:text-txt-black-900 mb-6 flex items-center">
                    <span class="bg-success-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-body-sm font-medium mr-3">5</span>
                    Semakan Terakhir
                </h2>
                <div class="space-y-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <h3 class="font-heading text-heading-xs font-medium text-txt-black-900 dark:text-txt-black-900 border-b border-otl-gray-200 dark:border-otl-gray-200 pb-2">
                                Maklumat Pemohon
                            </h3>
                            <div class="space-y-2 text-body-sm">
                                <div><strong>Nama:</strong> {{ $applicant_name ?: '-' }}</div>
                                <div><strong>Jawatan & Gred:</strong> {{ $applicant_position ?: '-' }}</div>
                                <div><strong>Bahagian/Unit:</strong> {{ $selectedDepartmentName ?: '-' }}</div>
                                <div><strong>No. Telefon:</strong> {{ $applicant_phone ?: '-' }}</div>
                                <div><strong>Lokasi:</strong> {{ $location ?: '-' }}</div>
                                <div><strong>Tarikh Pinjaman:</strong> {{ $loan_start_date ? \Carbon\Carbon::parse($loan_start_date)->format('d/m/Y') : '-' }}</div>
                                <div><strong>Tarikh Pulang:</strong> {{ $expected_return_date ? \Carbon\Carbon::parse($expected_return_date)->format('d/m/Y') : '-' }}</div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <h3 class="font-heading text-heading-xs font-medium text-txt-black-900 dark:text-txt-black-900 border-b border-otl-gray-200 dark:border-otl-gray-200 pb-2">
                                Pegawai Bertanggungjawab
                            </h3>
                            <div class="space-y-2 text-body-sm">
                                @if($sameAsApplicant)
                                    <div class="flex items-center text-primary-600 dark:text-primary-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Sama dengan Pemohon
                                    </div>
                                @else
                                    <div><strong>Nama:</strong> {{ $responsible_officer_name ?: '-' }}</div>
                                    <div><strong>Jawatan & Gred:</strong> {{ $responsible_officer_position ?: '-' }}</div>
                                    <div><strong>No. Telefon:</strong> {{ $responsible_officer_phone ?: '-' }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-heading text-heading-xs font-medium text-txt-black-900 dark:text-txt-black-900 border-b border-otl-gray-200 dark:border-otl-gray-200 pb-2 mb-3">
                            Tujuan Permohonan
                        </h3>
                        <div class="bg-bg-washed dark:bg-bg-washed p-4 rounded-radius-m text-body-sm">
                            {{ $purpose ?: 'Tiada tujuan dinyatakan' }}
                        </div>
                    </div>
                    <div>
                        <h3 class="font-heading text-heading-xs font-medium text-txt-black-900 dark:text-txt-black-900 border-b border-otl-gray-200 dark:border-otl-gray-200 pb-2 mb-4">
                            Peralatan yang Dipohon
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-otl-gray-200 dark:border-otl-gray-200 rounded-radius-m">
                                <thead class="bg-bg-washed dark:bg-bg-washed">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-body-xs font-medium text-txt-black-900 dark:text-txt-black-900">Bil.</th>
                                        <th class="px-4 py-2 text-left text-body-xs font-medium text-txt-black-900 dark:text-txt-black-900">Jenis Peralatan</th>
                                        <th class="px-4 py-2 text-left text-body-xs font-medium text-txt-black-900 dark:text-txt-black-900">Kuantiti</th>
                                        <th class="px-4 py-2 text-left text-body-xs font-medium text-txt-black-900 dark:text-txt-black-900">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-otl-gray-200 dark:divide-otl-gray-200">
                                    @foreach($equipmentRequests as $index => $request)
                                        @if($request['equipment_type'] && $request['quantity'])
                                            <tr class="text-body-sm">
                                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                                <td class="px-4 py-2">{{ $equipmentTypes[$request['equipment_type']] ?? $request['equipment_type'] }}</td>
                                                <td class="px-4 py-2">{{ $request['quantity'] }}</td>
                                                <td class="px-4 py-2">{{ $request['notes'] ?: '-' }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-heading text-heading-xs font-medium text-txt-black-900 dark:text-txt-black-900 border-b border-otl-gray-200 dark:border-otl-gray-200 pb-2 mb-3">
                            Status Sokongan
                        </h3>
                        <div class="bg-{{ $endorsement_status === 'supported' ? 'success' : 'danger' }}-25 dark:bg-{{ $endorsement_status === 'supported' ? 'success' : 'danger' }}-25 p-4 rounded-radius-m">
                            <div class="flex items-center space-x-3 mb-2">
                                <x-myds.tag :variant="$endorsement_status === 'supported' ? 'success' : 'danger'">
                                    {{ $endorsement_status === 'supported' ? 'DISOKONG' : 'TIDAK DISOKONG' }}
                                </x-myds.tag>
                                <span class="text-body-sm font-medium">oleh {{ $endorsing_officer_name }}</span>
                            </div>
                            <div class="text-body-xs text-txt-black-600 dark:text-txt-black-600">
                                Jawatan: {{ $endorsing_officer_position }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between mt-8">
                    <x-myds.button
                        type="button"
                        variant="secondary"
                        @click="currentStep = 4"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali
                    </x-myds.button>
                    <x-myds.button
                        type="submit"
                        variant="primary"
                        wire:loading.attr="disabled"
                        wire:target="submit"
                        @click="isSubmitting = true"
                        x-bind:disabled="isSubmitting"
                    >
                        <span wire:loading.remove wire:target="submit">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Hantar Permohonan
                        </span>
                        <span wire:loading wire:target="submit" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Menghantar...
                        </span>
                    </x-myds.button>
                </div>
            </x-myds.panel>
        </form>

        <!-- Success State -->
        @if(session()->has('success'))
            <div class="fixed inset-0 bg-gray-600/50 dark:bg-gray-900/50 flex items-center justify-center z-50"
                 x-data="{ show: true }"
                 x-show="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100">
                <div class="bg-bg-white-0 dark:bg-bg-white-0 rounded-radius-l shadow-context-menu p-8 max-w-lg mx-4 text-center">
                    <div class="w-16 h-16 bg-success-100 dark:bg-success-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-success-600 dark:text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h2 class="font-heading text-heading-s font-semibold text-txt-black-900 dark:text-txt-black-900 mb-2">
                        Permohonan Berjaya Dihantar
                    </h2>
                    <p class="text-body-sm text-txt-black-700 dark:text-txt-black-700 mb-4">
                        {{ session('success') }}
                    </p>
                    <div class="space-y-2 text-body-xs text-txt-black-500 dark:text-txt-black-500 mb-6">
                        <p>Rujukan: <strong class="text-txt-black-900 dark:text-txt-black-900">{{ session('reference_code') }}</strong></p>
                        <p>Permohonan akan diproses dalam tempoh 3 hari bekerja.</p>
                        <p>Sila bawa borang yang lengkap dan ditandatangani semasa mengambil peralatan.</p>
                    </div>
                    <div class="space-x-3">
                        <x-myds.button
                            type="button"
                            variant="secondary"
                            @click="window.print()"
                            size="sm"
                        >
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Print
                        </x-myds.button>
                        <x-myds.button
                            type="button"
                            variant="primary"
                            @click="show = false; window.location.href = '{{ route('dashboard') }}'"
                        >
                            Kembali ke Dashboard
                        </x-myds.button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
