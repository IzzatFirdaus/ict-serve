<div>
@section('title', __('forms.titles.equipment_loan_form_wizard'))

<!-- Content Banner -->
<div class="bg-bg-primary-50 border-b border-otl-divider">
    <div class="myds-container py-8">
        <div class="myds-grid-12">
            <div class="col-span-full">
                <h1 class="myds-heading-md text-txt-black-900 mb-2">{{ __('forms.titles.equipment_loan_form') }}</h1>
                <p class="text-txt-black-600 mb-3">{{ __('forms.subtitles.for_official_use') }}</p>
                <nav class="text-sm text-txt-black-500" aria-label="Breadcrumb">
                    <a href="/" class="hover:text-txt-primary">Utama</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('public.my-requests') }}" class="hover:text-txt-primary">ServiceDesk ICT</a>
                    <span class="mx-2">/</span>
                    <span>Permohonan Baru</span>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="myds-container py-12">
    <div class="myds-grid-12">
        <div class="col-span-full lg:col-span-10 lg:col-start-2">

            <!-- Progress Indicator -->
            <div class="mb-8">
                <div class="bg-white rounded-[var(--radius-xl)] border border-otl-gray-200 shadow-md p-6">
                        <h2 class="myds-heading-2xs text-txt-black-900 mb-4">{{ __('forms.progress.step_of', ['current' => $currentStep, 'total' => $totalSteps]) }}</h2>

                    <!-- Progress Bar -->
                    <div class="mb-6">
                        <div class="flex justify-between text-xs text-txt-black-500 mb-2">
                            <span>{{ __('forms.progress.step_of', ['current' => $currentStep, 'total' => $totalSteps]) }}</span>
                            <span>{{ __('forms.progress.percent_complete', ['percent' => round(($currentStep / $totalSteps) * 100)]) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-bg-primary-600 h-2 rounded-full transition-all duration-300"
                                 x-bind:style="'width: ' + {{ ($currentStep / $totalSteps) * 100 }} + '%'"></div>
                        </div>
                    </div>

                    <!-- Step Navigation -->
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-2 text-xs">
                        @for($i = 1; $i <= $totalSteps; $i++)
                            <button type="button"
                                    wire:click="goToStep({{ $i }})"
                                    class="p-2 rounded-[var(--radius-s)] text-center transition-colors
                                           {{ $i == $currentStep ? 'bg-bg-primary-600 text-white' :
                                              ($i < $currentStep ? 'bg-success-100 text-success-700' : 'bg-gray-100 text-txt-black-500') }}
                                           {{ $i <= $currentStep ? 'cursor-pointer hover:opacity-80' : 'cursor-not-allowed opacity-50' }}"
                                    {{ $i > $currentStep ? 'disabled' : '' }}>
                                {{ $i }}. {{ $this->getStepTitle($i) }}
                            </button>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-success-50 border border-otl-success-200 rounded-[var(--radius-m)]">
                    <div class="flex">
                        <x-icon name="check-circle" class="w-5 h-5 text-txt-success mt-0.5 mr-3" />
                        <div>
                            <h4 class="text-sm font-semibold text-txt-success mb-1">{{ __('alerts.success') }}</h4>
                            <p class="text-sm text-txt-success">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-danger-50 border border-otl-danger-200 rounded-[var(--radius-m)]">
                    <div class="flex">
                        <x-icon name="exclamation-circle" class="w-5 h-5 text-txt-danger mt-0.5 mr-3" />
                        <div>
                            <h4 class="text-sm font-semibold text-txt-danger mb-1">{{ __('alerts.error') }}</h4>
                            <p class="text-sm text-txt-danger">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Step Content -->
            <div class="bg-white rounded-[var(--radius-xl)] border border-otl-gray-200 shadow-md p-8">

                <!-- Step 1: Applicant Information -->
                @if($currentStep == 1)
                    <h2 class="myds-heading-xs text-txt-black-900 mb-6 pb-3 border-b border-otl-divider">
                        {{ __('forms.sections.applicant_info') }}
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-myds.form.input
                            :label="__('forms.labels.full_name')"
                            name="applicant_name"
                            wire:model="applicant_name"
                            required
                            :error="$errors->first('applicant_name')"
                            :placeholder="__('forms.placeholders.enter_full_name')"
                        />

                        <x-myds.form.input
                            :label="__('forms.labels.position_grade')"
                            name="applicant_position"
                            wire:model="applicant_position"
                            required
                            :error="$errors->first('applicant_position')"
                            :placeholder="__('forms.placeholders.example_position')"
                        />

                        <x-myds.form.select
                            :label="__('forms.labels.department')"
                            name="applicant_department"
                            wire:model="applicant_department"
                            required
                            :error="$errors->first('applicant_department')"
                            :options="$departmentOptions"
                            :placeholder="__('forms.placeholders.select_department')"
                        />

                        <x-myds.form.input
                            :label="__('forms.labels.phone')"
                            name="applicant_phone"
                            wire:model="applicant_phone"
                            required
                            :error="$errors->first('applicant_phone')"
                            :placeholder="__('forms.placeholders.enter_phone')"
                        />

                        <div class="md:col-span-2">
                            <x-myds.form.textarea
                                :label="__('forms.labels.purpose')"
                                name="purpose"
                                wire:model="purpose"
                                required
                                :error="$errors->first('purpose')"
                                :placeholder="__('forms.placeholders.enter_purpose')"
                                rows="3"
                            />
                        </div>

                        <x-myds.form.input
                            :label="__('forms.labels.location')"
                            name="location"
                            wire:model="location"
                            required
                            :error="$errors->first('location')"
                            :placeholder="__('forms.placeholders.enter_location')"
                        />

                        <x-myds.form.input
                            :label="__('forms.labels.loan_start_date')"
                            name="loan_start_date"
                            type="date"
                            wire:model="loan_start_date"
                            required
                            :error="$errors->first('loan_start_date')"
                        />

                        <x-myds.form.input
                            :label="__('forms.labels.loan_end_date')"
                            name="expected_return_date"
                            type="date"
                            wire:model="expected_return_date"
                            required
                            :error="$errors->first('expected_return_date')"
                        />
                    </div>
                @endif

                <!-- Step 2: Responsible Officer Information -->
                @if($currentStep == 2)
                    <h2 class="myds-heading-xs text-txt-black-900 mb-6 pb-3 border-b border-otl-divider">
                        {{ __('forms.sections.responsible_officer_info') }}
                    </h2>

                    <div class="mb-6">
                        <x-myds.form.checkbox
                            :label="__('forms.labels.same_as_applicant')"
                            name="same_as_applicant"
                            wire:model.live="same_as_applicant"
                        />
                    </div>

                    @if(!$same_as_applicant)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-gray-50 rounded-[var(--radius-m)]">
                                <x-myds.form.input
                                :label="__('forms.labels.full_name')"
                                name="responsible_officer_name"
                                wire:model="responsible_officer_name"
                                required
                                :error="$errors->first('responsible_officer_name')"
                                :placeholder="__('forms.placeholders.enter_full_name')"
                            />

                                <x-myds.form.input
                                :label="__('forms.labels.position_grade')"
                                name="responsible_officer_position"
                                wire:model="responsible_officer_position"
                                required
                                :error="$errors->first('responsible_officer_position')"
                                :placeholder="__('forms.placeholders.example_position')"
                            />

                            <x-myds.form.input
                                label="No. Telefon"
                                name="responsible_officer_phone"
                                wire:model="responsible_officer_phone"
                                required
                                :error="$errors->first('responsible_officer_phone')"
                                placeholder="012-3456789"
                            />
                        </div>
                    @else
                        <div class="p-4 bg-success-50 border border-otl-success-200 rounded-[var(--radius-m)]">
                            <p class="text-txt-success text-sm">
                                <x-icon name="check-circle" class="w-4 h-4 inline mr-2" />
                                {{ __('forms.terms.applicant_responsibility') }}
                            </p>
                        </div>
                    @endif
                @endif

                <!-- Step 3: Equipment Information -->
                @if($currentStep == 3)
                    <h2 class="myds-heading-xs text-txt-black-900 mb-6 pb-3 border-b border-otl-divider">
                        {{ __('forms.sections.equipment_info') }}
                    </h2>

                    <div class="space-y-4">
                        @foreach($equipment_requests as $index => $request)
                            <div class="p-4 border border-otl-gray-200 rounded-[var(--radius-m)] {{ $index > 0 ? 'bg-gray-50' : '' }}">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-sm font-semibold text-txt-black-900">{{ __('literals.equipment') }} {{ $index + 1 }}</h3>
                                    @if($index > 0)
                                        <x-myds.button
                                            type="button"
                                            variant="danger"
                                            size="sm"
                                            wire:click="removeEquipmentRequest({{ $index }})"
                                        >
                                            {{ __('buttons.remove') }}
                                        </x-myds.button>
                                    @endif
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <x-myds.form.select
                                        :label="__('forms.labels.equipment_type')"
                                        name="equipment_requests.{{ $index }}.type"
                                        wire:model="equipment_requests.{{ $index }}.type"
                                        required
                                        :error="$errors->first('equipment_requests.' . $index . '.type')"
                                        :options="$equipmentTypeOptions"
                                        :placeholder="__('forms.placeholders.select_equipment_type')"
                                    />

                                        <x-myds.form.input
                                        :label="__('forms.labels.quantity')"
                                        name="equipment_requests.{{ $index }}.quantity"
                                        type="number"
                                        wire:model="equipment_requests.{{ $index }}.quantity"
                                        required
                                        min="1"
                                        max="10"
                                        :error="$errors->first('equipment_requests.' . $index . '.quantity')"
                                    />

                                        <x-myds.form.input
                                        :label="__('forms.labels.notes')"
                                        name="equipment_requests.{{ $index }}.notes"
                                        wire:model="equipment_requests.{{ $index }}.notes"
                                        :placeholder="__('forms.placeholders.notes') ?? 'Spesifikasi khusus (jika ada)'"
                                    />
                                </div>
                            </div>
                        @endforeach

                        <div class="flex justify-center">
                            <x-myds.button
                                type="button"
                                variant="outline"
                                wire:click="addEquipmentRequest"
                            >
                                <x-icon name="plus" class="w-4 h-4 mr-2" />
                                {{ __('buttons.add_equipment') }}
                            </x-myds.button>
                        </div>
                    </div>
                @endif

                <!-- Step 4: Applicant's Confirmation -->
                @if($currentStep == 4)
                    <h2 class="myds-heading-xs text-txt-black-900 mb-6 pb-3 border-b border-otl-divider">
                        Bahagian 4: Pengesahan Pemohon
                    </h2>

                    <div class="space-y-6">
                        <div class="p-4 bg-warning-50 border border-otl-warning-200 rounded-[var(--radius-m)]">
                            <h3 class="text-txt-warning font-semibold mb-2">{{ __('forms.terms.title') }}</h3>
                            <p class="text-sm text-txt-warning mb-4">
                                Saya dengan ini mengesahkan bahawa peralatan yang dipinjam adalah untuk kegunaan rasmi
                                dan akan berada di bawah tanggungjawab saya sepanjang tempoh peminjaman.
                            </p>

                                <x-myds.form.checkbox
                                :label="__('forms.labels.declaration_text')"
                                name="confirmation_declaration_accepted"
                                wire:model="confirmation_declaration_accepted"
                                required
                                :error="$errors->first('confirmation_declaration_accepted')"
                            />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-myds.form.input
                                label="Tarikh"
                                name="confirmation_date"
                                type="date"
                                wire:model="confirmation_date"
                                required
                                :error="$errors->first('confirmation_date')"
                            />

                            <div>
                                <x-signature-pad
                                    wire-model="applicant_signature"
                                    :label="__('forms.labels.signature') ?? 'Tandatangan Digital'"
                                    required
                                    height="150px"
                                />
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Step 5: Endorsement -->
                @if($currentStep == 5)
                    <h2 class="myds-heading-xs text-txt-black-900 mb-6 pb-3 border-b border-otl-divider">
                        Bahagian 5: Pengesahan Penyelia
                    </h2>

                    <div class="space-y-6">
                        <div class="p-4 bg-bg-primary-50 border border-otl-primary-200 rounded-[var(--radius-m)]">
                            <p class="text-sm text-txt-primary">
                                <x-icon name="info-circle" class="w-4 h-4 inline mr-2" />
                                {{ __('forms.terms.approval_requirement') }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-myds.form.input
                                label="Nama Pegawai Penyokong"
                                name="endorsing_officer_name"
                                wire:model="endorsing_officer_name"
                                required
                                :error="$errors->first('endorsing_officer_name')"
                                placeholder="Nama pegawai yang mengesahkan"
                            />

                            <x-myds.form.input
                                label="Jawatan & Gred"
                                name="endorsing_officer_position"
                                wire:model="endorsing_officer_position"
                                required
                                :error="$errors->first('endorsing_officer_position')"
                                placeholder="Contoh: Penolong Pengarah F54"
                            />

                            <div>
                                <label class="block text-sm font-medium text-txt-black-900 mb-2 required">
                                    Status Sokongan
                                </label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio"
                                               wire:model="endorsement_status"
                                               value="supported"
                                               class="mr-2 text-txt-primary focus:ring-fr-primary">
                                        <span class="text-txt-success">{{ __('status.supported') }}</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio"
                                               wire:model="endorsement_status"
                                               value="not_supported"
                                               class="mr-2 text-txt-primary focus:ring-fr-primary">
                                        <span class="text-txt-danger">{{ __('status.rejected') }}</span>
                                    </label>
                                </div>
                                @error('endorsement_status')
                                    <p class="text-sm text-txt-danger mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <x-myds.form.input
                                label="Tarikh"
                                name="endorsement_date"
                                type="date"
                                wire:model="endorsement_date"
                                required
                                :error="$errors->first('endorsement_date')"
                            />
                        </div>

                        <x-myds.form.textarea
                            label="Catatan (jika ada)"
                            name="endorsement_comments"
                            wire:model="endorsement_comments"
                            placeholder="Catatan tambahan mengenai permohonan ini..."
                            rows="3"
                        />

                        <div>
                            <x-signature-pad
                                wire-model="endorsement_signature"
                                label="Tandatangan & Cop"
                                required
                                height="150px"
                            />
                        </div>
                    </div>
                @endif

                <!-- Steps 6-8: BPM Use Only (Read-only for most users) -->
                @if($currentStep >= 6)
                    <div class="text-center py-8">
                        <x-icon name="lock-closed" class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                        <h3 class="myds-heading-2xs text-txt-black-900 mb-2">{{ __('forms.sections.bpm') ?? 'Bahagian BPM' }}</h3>
                        <p class="text-txt-black-600 mb-4">
                            {{ __('forms.sections.bpm_notice', ['current' => $currentStep, 'total' => $totalSteps]) ?? "Langkah $currentStep hingga $totalSteps adalah untuk kegunaan kakitangan BPM sahaja." }}
                        </p>

                        @if($currentStep == 6)
                            <p class="text-sm text-txt-black-500">{{ __('forms.bpm.step_6') ?? 'Proses pengambilan peralatan' }}</p>
                        @elseif($currentStep == 7)
                            <p class="text-sm text-txt-black-500">{{ __('forms.bpm.step_7') ?? 'Proses pemulangan peralatan' }}</p>
                        @elseif($currentStep == 8)
                            <p class="text-sm text-txt-black-500">{{ __('forms.bpm.step_8') ?? 'Maklumat terperinci peralatan' }}</p>
                        @endif
                    </div>
                @endif

            </div>

            <!-- Navigation Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                @if($currentStep > 1)
                    <x-myds.button
                        type="button"
                        variant="secondary"
                        wire:click="previousStep"
                        class="flex-1"
                    >
                        <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                        {{ __('buttons.previous_step') }}
                    </x-myds.button>
                @endif

                @if($currentStep < 5)
                    <x-myds.button
                        type="button"
                        wire:click="nextStep"
                        class="flex-1"
                    >
                        {{ __('buttons.next_step') }}
                        <x-icon name="arrow-right" class="w-4 h-4 ml-2" />
                    </x-myds.button>
                @elseif($currentStep == 5)
                    <x-myds.button
                        type="button"
                        wire:click="submitApplication"
                        class="flex-1"
                        wire:loading.attr="disabled"
                        wire:target="submitApplication"
                    >
                        <span wire:loading.remove wire:target="submitApplication">
                            {{ __('buttons.submit_application') }}
                            <x-icon name="paper-airplane" class="w-4 h-4 ml-2" />
                        </span>
                        <span wire:loading wire:target="submitApplication">
                            {{ __('buttons.sending') }}
                        </span>
                    </x-myds.button>
                @endif

                <x-myds.button
                    type="button"
                    variant="outline"
                    wire:click="resetForm"
                    wire:confirm="Adakah anda pasti untuk menetapkan semula borang? Semua data akan hilang."
                >
                    {{ __('buttons.reset_form') }}
                </x-myds.button>
            </div>

            <!-- Save Progress Notice -->
            <div class="mt-6 p-4 bg-bg-primary-50 border border-otl-primary-200 rounded-[var(--radius-m)]">
                <p class="text-sm text-txt-primary">
                    <x-icon name="save" class="w-4 h-4 inline mr-2" />
                    {{ __('forms.notice.auto_save') }}
                </p>
            </div>

            <!-- Terms and Conditions -->
            <div class="mt-8 p-6 bg-warning-50 border border-otl-warning-200 rounded-[var(--radius-m)]">
                <h3 class="myds-heading-2xs text-txt-warning mb-4">{{ __('forms.terms.title') }}</h3>
                <div class="space-y-2 text-sm text-txt-warning">
                    <p>• {{ __('forms.terms.complete_form') }}</p>
                    <p>• {{ __('forms.terms.availability') }}</p>
                    <p>• {{ __('forms.terms.processing_time') }}</p>
                    <p>• {{ __('forms.terms.applicant_responsibility') }}</p>
                    <p>• {{ __('forms.terms.approval_requirement') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@vite('resources/js/livewire/loan-application-wizard.js')
</div>
