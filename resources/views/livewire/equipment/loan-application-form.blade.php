<div class="myds-container max-w-6xl mx-auto py-8">
    <!-- Form Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-heading-l font-semibold text-txt-black-900">
                Borang Permohonan Pinjaman Peralatan ICT
            </h1>
            <span class="myds-tag myds-tag-primary text-body-sm font-medium">
                {{ $formReference }}
            </span>
        </div>
        <p class="text-body-base text-txt-black-700">
            Sila lengkapkan borang ini untuk memohon pinjaman peralatan ICT.
            Semua maklumat yang bertanda <span class="text-danger-600">*</span> adalah wajib diisi.
        </p>
    </div>

    <!-- Form Progress Indicator -->
    <div class="mb-8">
        <div class="flex items-center justify-between text-body-sm">
            <div class="flex items-center space-x-2">
                <div class="w-6 h-6 bg-primary-600 text-white rounded-full flex items-center justify-center font-medium">1</div>
                <span class="text-txt-black-700">Maklumat Pemohon</span>
            </div>
            <div class="flex-1 h-px bg-otl-gray-300 mx-4"></div>
            <div class="flex items-center space-x-2">
                <div class="w-6 h-6 bg-primary-600 text-white rounded-full flex items-center justify-center font-medium">2</div>
                <span class="text-txt-black-700">Pegawai Bertanggungjawab</span>
            </div>
            <div class="flex-1 h-px bg-otl-gray-300 mx-4"></div>
            <div class="flex items-center space-x-2">
                <div class="w-6 h-6 bg-primary-600 text-white rounded-full flex items-center justify-center font-medium">3</div>
                <span class="text-txt-black-700">Maklumat Peralatan</span>
            </div>
            <div class="flex-1 h-px bg-otl-gray-300 mx-4"></div>
            <div class="flex items-center space-x-2">
                <div class="w-6 h-6 bg-primary-600 text-white rounded-full flex items-center justify-center font-medium">4</div>
                <span class="text-txt-black-700">Perakuan</span>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form wire:submit="submit"
          class="space-y-8"
          novalidate
          aria-label="Borang Permohonan Pinjaman Peralatan ICT">

        <!-- Part 1: Applicant Information -->
        <section class="myds-panel myds-panel-info" aria-labelledby="applicant-info-heading">
            <h2 id="applicant-info-heading" class="text-heading-m font-medium text-txt-black-900 mb-6">
                Bahagian 1: Maklumat Pemohon
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Applicant Name -->
                <div class="myds-field">
                    <label for="applicant_name" class="myds-label">
                        Nama Penuh <span class="text-danger-600" aria-label="wajib">*</span>
                    </label>
                    <input type="text"
                           id="applicant_name"
                           wire:model.blur="applicant_name"
                           class="myds-input @error('applicant_name') myds-input-error @enderror"
                           placeholder="Contoh: Ahmad bin Ali"
                           aria-describedby="applicant_name_error"
                           required>
                    @error('applicant_name')
                        <div id="applicant_name_error" class="myds-field-error" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Applicant Position -->
                <div class="myds-field">
                    <label for="applicant_position" class="myds-label">
                        Jawatan <span class="text-danger-600" aria-label="wajib">*</span>
                    </label>
                    <input type="text"
                           id="applicant_position"
                           wire:model.blur="applicant_position"
                           class="myds-input @error('applicant_position') myds-input-error @enderror"
                           placeholder="Contoh: Penolong Pegawai Teknologi Maklumat"
                           aria-describedby="applicant_position_error"
                           required>
                    @error('applicant_position')
                        <div id="applicant_position_error" class="myds-field-error" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Applicant Division -->
                <div class="myds-field">
                    <label for="applicant_division" class="myds-label">
                        Bahagian <span class="text-danger-600" aria-label="wajib">*</span>
                    </label>
                    <select id="applicant_division"
                            wire:model.blur="applicant_division"
                            class="myds-select @error('applicant_division') myds-input-error @enderror"
                            aria-describedby="applicant_division_error"
                            required>
                        <option value="">Pilih Bahagian</option>
                        @foreach($divisions as $div)
                            <option value="{{ $div }}">{{ $div }}</option>
                        @endforeach
                    </select>
                    @error('applicant_division')
                        <div id="applicant_division_error" class="myds-field-error" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Applicant Grade -->
                <div class="myds-field">
                    <label for="applicant_grade" class="myds-label">
                        Gred Jawatan
                    </label>
                    <input type="text"
                           id="applicant_grade"
                           wire:model.blur="applicant_grade"
                           class="myds-input"
                           placeholder="Contoh: N41, M48, JUSA C"
                           maxlength="10">
                    <p class="myds-field-hint">Pilihan - Jika berkenaan</p>
                </div>

                <!-- Applicant Email -->
                <div class="myds-field">
                    <label for="applicant_email" class="myds-label">
                        Alamat E-mel <span class="text-danger-600" aria-label="wajib">*</span>
                    </label>
                    <input type="email"
                           id="applicant_email"
                           wire:model.blur="applicant_email"
                           class="myds-input @error('applicant_email') myds-input-error @enderror"
                           placeholder="contoh@motac.gov.my"
                           aria-describedby="applicant_email_error"
                           required>
                    @error('applicant_email')
                        <div id="applicant_email_error" class="myds-field-error" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Applicant Phone -->
                <div class="myds-field">
                    <label for="applicant_phone" class="myds-label">
                        Nombor Telefon <span class="text-danger-600" aria-label="wajib">*</span>
                    </label>
                    <input type="tel"
                           id="applicant_phone"
                           wire:model.blur="applicant_phone"
                           class="myds-input @error('applicant_phone') myds-input-error @enderror"
                           placeholder="Contoh: +60123456789 atau 0123456789"
                           aria-describedby="applicant_phone_error"
                           required>
                    @error('applicant_phone')
                        <div id="applicant_phone_error" class="myds-field-error" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </section>

        <!-- Part 2: Responsible Officer Information -->
        <section class="myds-panel myds-panel-warning" aria-labelledby="officer-info-heading">
            <h2 id="officer-info-heading" class="text-heading-m font-medium text-txt-black-900 mb-6">
                Bahagian 2: Maklumat Pegawai Bertanggungjawab
            </h2>

            <!-- Same as Applicant Checkbox -->
            <div class="myds-field mb-6">
                <div class="flex items-start space-x-3">
                    <input type="checkbox"
                           id="same_as_applicant"
                           wire:model.live="same_as_applicant"
                           class="myds-checkbox"
                           value="1">
                    <label for="same_as_applicant" class="myds-label cursor-pointer">
                        Sama seperti maklumat pemohon
                    </label>
                </div>
                <p class="myds-field-hint mt-2">
                    Tandakan jika pegawai bertanggungjawab adalah sama dengan pemohon
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Officer Name -->
                <div class="myds-field">
                    <label for="officer_name" class="myds-label">
                        Nama Penuh <span class="text-danger-600" aria-label="wajib">*</span>
                    </label>
                    <input type="text"
                           id="officer_name"
                           wire:model.blur="officer_name"
                           class="myds-input @error('officer_name') myds-input-error @enderror"
                           placeholder="Contoh: Ahmad bin Ali"
                           aria-describedby="officer_name_error"
                           :disabled="same_as_applicant"
                           required>
                    @error('officer_name')
                        <div id="officer_name_error" class="myds-field-error" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Officer Position -->
                <div class="myds-field">
                    <label for="officer_position" class="myds-label">
                        Jawatan <span class="text-danger-600" aria-label="wajib">*</span>
                    </label>
                    <input type="text"
                           id="officer_position"
                           wire:model.blur="officer_position"
                           class="myds-input @error('officer_position') myds-input-error @enderror"
                           placeholder="Contoh: Pegawai Teknologi Maklumat"
                           aria-describedby="officer_position_error"
                           :disabled="same_as_applicant"
                           required>
                    @error('officer_position')
                        <div id="officer_position_error" class="myds-field-error" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Officer Division -->
                <div class="myds-field">
                    <label for="officer_division" class="myds-label">
                        Bahagian <span class="text-danger-600" aria-label="wajib">*</span>
                    </label>
                    <select id="officer_division"
                            wire:model.blur="officer_division"
                            class="myds-select @error('officer_division') myds-input-error @enderror"
                            aria-describedby="officer_division_error"
                            :disabled="same_as_applicant"
                            required>
                        <option value="">Pilih Bahagian</option>
                        @foreach($divisions as $div)
                            <option value="{{ $div }}">{{ $div }}</option>
                        @endforeach
                    </select>
                    @error('officer_division')
                        <div id="officer_division_error" class="myds-field-error" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Officer Grade -->
                <div class="myds-field">
                    <label for="officer_grade" class="myds-label">
                        Gred Jawatan
                    </label>
                    <input type="text"
                           id="officer_grade"
                           wire:model.blur="officer_grade"
                           class="myds-input"
                           placeholder="Contoh: N41, M48, JUSA C"
                           maxlength="10"
                           :disabled="same_as_applicant">
                    <p class="myds-field-hint">Pilihan - Jika berkenaan</p>
                </div>

                <!-- Officer Email -->
                <div class="myds-field">
                    <label for="officer_email" class="myds-label">
                        Alamat E-mel <span class="text-danger-600" aria-label="wajib">*</span>
                    </label>
                    <input type="email"
                           id="officer_email"
                           wire:model.blur="officer_email"
                           class="myds-input @error('officer_email') myds-input-error @enderror"
                           placeholder="contoh@motac.gov.my"
                           aria-describedby="officer_email_error"
                           :disabled="same_as_applicant"
                           required>
                    @error('officer_email')
                        <div id="officer_email_error" class="myds-field-error" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Officer Phone -->
                <div class="myds-field">
                    <label for="officer_phone" class="myds-label">
                        Nombor Telefon <span class="text-danger-600" aria-label="wajib">*</span>
                    </label>
                    <input type="tel"
                           id="officer_phone"
                           wire:model.blur="officer_phone"
                           class="myds-input @error('officer_phone') myds-input-error @enderror"
                           placeholder="Contoh: +60123456789 atau 0123456789"
                           aria-describedby="officer_phone_error"
                           :disabled="same_as_applicant"
                           required>
                    @error('officer_phone')
                        <div id="officer_phone_error" class="myds-field-error" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </section>

        <!-- Part 3: Equipment Information -->
        <section class="myds-panel myds-panel-success" aria-labelledby="equipment-info-heading">
            <h2 id="equipment-info-heading" class="text-heading-m font-medium text-txt-black-900 mb-6">
                Bahagian 3: Maklumat Peralatan dan Tempoh Pinjaman
            </h2>

            <!-- Loan Period -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Start Date -->
                <div class="myds-field">
                    <label for="loan_start_date" class="myds-label">
                        Tarikh Mula Pinjaman <span class="text-danger-600" aria-label="wajib">*</span>
                    </label>
                    <input type="date"
                           id="loan_start_date"
                           wire:model.blur="loan_start_date"
                           class="myds-input @error('loan_start_date') myds-input-error @enderror"
                           aria-describedby="loan_start_date_error"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           required>
                    @error('loan_start_date')
                        <div id="loan_start_date_error" class="myds-field-error" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- End Date -->
                <div class="myds-field">
                    <label for="loan_end_date" class="myds-label">
                        Tarikh Tamat Pinjaman <span class="text-danger-600" aria-label="wajib">*</span>
                    </label>
                    <input type="date"
                           id="loan_end_date"
                           wire:model.blur="loan_end_date"
                           class="myds-input @error('loan_end_date') myds-input-error @enderror"
                           aria-describedby="loan_end_date_error"
                           min="{{ $loan_start_date ?: date('Y-m-d', strtotime('+2 days')) }}"
                           required>
                    @error('loan_end_date')
                        <div id="loan_end_date_error" class="myds-field-error" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Purpose -->
                <div class="myds-field md:col-span-2">
                    <label for="loan_purpose" class="myds-label">
                        Tujuan Pinjaman <span class="text-danger-600" aria-label="wajib">*</span>
                    </label>
                    <textarea id="loan_purpose"
                              wire:model.blur="loan_purpose"
                              class="myds-textarea @error('loan_purpose') myds-input-error @enderror"
                              rows="3"
                              maxlength="500"
                              placeholder="Contoh: Untuk persembahan projek di mesyuarat bulanan, kursus latihan, dll."
                              aria-describedby="loan_purpose_error loan_purpose_hint"
                              required></textarea>
                    <p id="loan_purpose_hint" class="myds-field-hint">
                        Nyatakan dengan jelas tujuan pinjaman peralatan (Maksimum 500 aksara)
                    </p>
                    @error('loan_purpose')
                        <div id="loan_purpose_error" class="myds-field-error" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Equipment Requests Table -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-heading-s font-medium text-txt-black-900">
                        Senarai Peralatan Diperlukan
                    </h3>
                    <button type="button"
                            wire:click="addEquipmentRow"
                            class="myds-btn-secondary myds-btn-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Peralatan
                    </button>
                </div>

                <!-- Equipment Requests -->
                <div class="space-y-4">
                    @foreach($this->equipmentRequests as $index => $request)
                        <div class="border border-otl-gray-200 rounded-lg p-4"
                             wire:key="equipment-{{ $index }}">
                            <div class="flex items-start justify-between mb-4">
                                <h4 class="text-body-sm font-medium text-txt-black-900">
                                    Peralatan {{ $index + 1 }}
                                </h4>
                                @if(count($this->equipmentRequests) > 1)
                                    <button type="button"
                                            wire:click="removeEquipmentRow({{ $index }})"
                                            class="text-danger-600 hover:text-danger-700 p-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Equipment Selection -->
                                <div class="myds-field">
                                    <label for="equipment_requests.{{ $index }}.equipment_id" class="myds-label">
                                        Pilih Peralatan <span class="text-danger-600">*</span>
                                    </label>
                                    <select wire:model.blur="equipment_requests.{{ $index }}.equipment_id"
                                            class="myds-select @error('equipment_requests.'.$index.'.equipment_id') myds-input-error @enderror"
                                            required>
                                        <option value="">-- Pilih Peralatan --</option>
                                        @foreach($equipmentTypes as $key => $equipmentName)
                                            <option value="{{ $key }}">
                                                {{ $equipmentName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('equipment_requests.'.$index.'.equipment_id')
                                        <div class="myds-field-error" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Quantity -->
                                <div class="myds-field">
                                    <label for="equipment_requests.{{ $index }}.quantity" class="myds-label">
                                        Kuantiti <span class="text-danger-600">*</span>
                                    </label>
                                    <input type="number"
                                           wire:model.blur="equipment_requests.{{ $index }}.quantity"
                                           class="myds-input @error('equipment_requests.'.$index.'.quantity') myds-input-error @enderror"
                                           min="1"
                                           max="10"
                                           required>
                                    @error('equipment_requests.'.$index.'.quantity')
                                        <div class="myds-field-error" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Remarks -->
                                <div class="myds-field">
                                    <label for="equipment_requests.{{ $index }}.remarks" class="myds-label">
                                        Catatan
                                    </label>
                                    <input type="text"
                                           wire:model.blur="equipment_requests.{{ $index }}.remarks"
                                           class="myds-input"
                                           placeholder="Keperluan khas (jika ada)"
                                           maxlength="255">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @error('equipment_requests')
                    <div class="myds-field-error" role="alert">{{ $message }}</div>
                @enderror
            </div>
        </section>

        <!-- Part 4: Declaration -->
        <section class="myds-panel myds-panel-danger" aria-labelledby="declaration-heading">
            <h2 id="declaration-heading" class="text-heading-m font-medium text-txt-black-900 mb-6">
                Bahagian 4: Perakuan
            </h2>

            <div class="myds-field">
                <div class="flex items-start space-x-3">
                    <input type="checkbox"
                           id="declaration_accepted"
                           wire:model.blur="declaration_accepted"
                           class="myds-checkbox @error('declaration_accepted') myds-input-error @enderror"
                           value="1"
                           aria-describedby="declaration_error declaration_text"
                           required>
                    <div>
                        <label for="declaration_accepted" class="myds-label cursor-pointer">
                            Perakuan <span class="text-danger-600" aria-label="wajib">*</span>
                        </label>
                        <div id="declaration_text" class="mt-2 text-body-sm text-txt-black-700 leading-relaxed bg-bg-washed p-4 rounded-lg border-l-4 border-primary-600">
                            <p class="mb-3">
                                <strong>Saya dengan ini mengaku dan mengesahkan bahawa:</strong>
                            </p>
                            <ol class="list-decimal list-inside space-y-2 ml-4">
                                <li>Semua maklumat yang diberikan dalam borang ini adalah benar dan tepat.</li>
                                <li>Saya akan menggunakan peralatan yang dipinjam dengan bertanggungjawab dan hanya untuk tujuan rasmi yang dinyatakan.</li>
                                <li>Saya akan memulangkan peralatan dalam keadaan baik dan pada tarikh yang ditetapkan.</li>
                                <li>Saya bertanggungjawab sepenuhnya ke atas sebarang kerosakan atau kehilangan peralatan semasa tempoh pinjaman.</li>
                                <li>Saya akan melaporkan dengan segera sebarang kerosakan atau masalah yang berlaku pada peralatan.</li>
                                <li>Saya memahami bahawa pelanggaran terhadap syarat-syarat ini boleh mengakibatkan tindakan disiplin dan sekatan pinjaman pada masa akan datang.</li>
                            </ol>
                        </div>
                    </div>
                </div>
                @error('declaration_accepted')
                    <div id="declaration_error" class="myds-field-error" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </section>

        <!-- Form Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-end pt-6 border-t border-otl-gray-200">
            <button type="button"
                    class="myds-btn-secondary"
                    onclick="if(confirm('Adakah anda pasti mahu membatalkan? Semua data yang dimasukkan akan hilang.')) {
                        window.history.back();
                    }">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Batal
            </button>

            <button type="submit"
                    class="myds-btn-primary"
                    wire:loading.attr="disabled"
                    wire:target="submit">
                <span wire:loading.remove wire:target="submit">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Hantar Permohonan
                </span>
                <span wire:loading wire:target="submit" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Menghantar...
                </span>
            </button>
        </div>
    </form>

    <!-- Security Notice -->
    <div class="mt-8 text-center">
        <div class="flex items-center justify-center space-x-2 text-body-sm text-txt-black-500">
            <svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
            </svg>
            <span>Maklumat anda dilindungi dan disulitkan</span>
        </div>
    </div>
    <!-- Same styles as damage complaint form -->
    <style>
        .myds-field {
            @apply space-y-2;
        }

        .myds-label {
            @apply block text-body-sm font-medium text-txt-black-900;
        }

        .myds-input, .myds-select, .myds-textarea {
            @apply w-full px-4 py-3 border border-otl-gray-300 rounded-lg
                   bg-bg-white-0 text-txt-black-900 text-body-sm
                   focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-primary-600
                   disabled:bg-bg-washed disabled:text-txt-black-400
                   transition-colors duration-200;
        }

        .myds-input-error {
            @apply border-danger-600 focus:ring-danger-600 focus:border-danger-600;
        }

        .myds-field-error {
            @apply text-body-sm text-danger-600 mt-1;
        }

        .myds-field-hint {
            @apply text-body-xs text-txt-black-500 mt-1;
        }

        .myds-checkbox {
            @apply w-4 h-4 text-primary-600 bg-bg-white-0 border-otl-gray-300 rounded
                   focus:ring-primary-600 focus:ring-2;
        }

        .myds-textarea {
            @apply resize-y min-h-[120px];
        }
    </style>
</div>
