<div class="myds-container max-w-4xl mx-auto py-8">
    <!-- Form Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-heading-l font-semibold text-txt-black-900">
                Borang Aduan Kerosakan ICT
            </h1>
            <span class="myds-tag myds-tag-primary text-body-sm font-medium">
                {{ $formReference }}
            </span>
        </div>
        <p class="text-body-base text-txt-black-700">
            Sila lengkapkan borang ini untuk mengadukan kerosakan peralatan ICT.
            Semua maklumat yang bertanda <span class="text-danger-600">*</span> adalah wajib diisi.
        </p>
    </div>

    <!-- Form -->
    <form wire:submit="submit"
          class="space-y-8"
          novalidate
          aria-label="Borang Aduan Kerosakan ICT">

        <!-- Section 1: Maklumat Pelapor -->
        <section class="myds-panel myds-panel-info" aria-labelledby="reporter-info-heading">
            <h2 id="reporter-info-heading" class="text-heading-m font-medium text-txt-black-900 mb-6">
                1. Maklumat Pelapor
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Penuh -->
                <div class="myds-field">
                    <label for="full_name" class="myds-label">
                        Nama Penuh <span class="text-danger-600" aria-label="wajib">*</span>
                    </label>
                    <input type="text"
                           id="full_name"
                           wire:model.blur="full_name"
                           class="myds-input @error('full_name') myds-input-error @enderror"
                           placeholder="Contoh: Ahmad bin Ali"
                           aria-describedby="full_name_error"
                           required>
                    @error('full_name')
                        <div id="full_name_error" class="myds-field-error" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Bahagian -->
                <div class="myds-field">
                    <label for="division" class="myds-label">
                        Bahagian <span class="text-danger-600" aria-label="wajib">*</span>
                    </label>
                    <select id="division"
                            wire:model.blur="division"
                            class="myds-select @error('division') myds-input-error @enderror"
                            aria-describedby="division_error"
                            required>
                        <option value="">Pilih Bahagian</option>
                        @foreach($divisions as $div)
                            <option value="{{ $div }}">{{ $div }}</option>
                        @endforeach
                    </select>
                    @error('division')
                        <div id="division_error" class="myds-field-error" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Gred Jawatan (Optional) -->
                <div class="myds-field">
                    <label for="position_grade" class="myds-label">
                        Gred Jawatan
                    </label>
                    <input type="text"
                           id="position_grade"
                           wire:model.blur="position_grade"
                           class="myds-input"
                           placeholder="Contoh: N41, M48, JUSA C"
                           maxlength="10">
                    <p class="myds-field-hint">
                        Pilihan - Jika berkenaan
                    </p>
                </div>

                <!-- E-mel -->
                <div class="myds-field">
                    <label for="email" class="myds-label">
                        Alamat E-mel <span class="text-danger-600" aria-label="wajib">*</span>
                    </label>
                    <input type="email"
                           id="email"
                           wire:model.blur="email"
                           class="myds-input @error('email') myds-input-error @enderror"
                           placeholder="contoh@motac.gov.my"
                           aria-describedby="email_error"
                           required>
                    @error('email')
                        <div id="email_error" class="myds-field-error" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Nombor Telefon -->
                <div class="myds-field md:col-span-2">
                    <label for="phone_number" class="myds-label">
                        Nombor Telefon <span class="text-danger-600" aria-label="wajib">*</span>
                    </label>
                    <input type="tel"
                           id="phone_number"
                           wire:model.blur="phone_number"
                           class="myds-input @error('phone_number') myds-input-error @enderror"
                           placeholder="Contoh: +60123456789 atau 0123456789"
                           aria-describedby="phone_number_error phone_number_hint"
                           required>
                    <p id="phone_number_hint" class="myds-field-hint">
                        Sertakan kod negara untuk nombor telefon luar negara
                    </p>
                    @error('phone_number')
                        <div id="phone_number_error" class="myds-field-error" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </section>

        <!-- Section 2: Maklumat Kerosakan -->
        <section class="myds-panel myds-panel-warning" aria-labelledby="damage-info-heading">
            <h2 id="damage-info-heading" class="text-heading-m font-medium text-txt-black-900 mb-6">
                2. Maklumat Kerosakan
            </h2>

            <div class="space-y-6">
                <!-- Jenis Kerosakan -->
                <div class="myds-field">
                    <label for="damage_type" class="myds-label">
                        Jenis Kerosakan <span class="text-danger-600" aria-label="wajib">*</span>
                    </label>
                    <select id="damage_type"
                            wire:model.blur="damage_type"
                            class="myds-select @error('damage_type') myds-input-error @enderror"
                            aria-describedby="damage_type_error"
                            required>
                        <option value="">Pilih Jenis Kerosakan</option>
                        @foreach($damageTypes as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('damage_type')
                        <div id="damage_type_error" class="myds-field-error" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Maklumat Kerosakan -->
                <div class="myds-field">
                    <label for="damage_information" class="myds-label">
                        Maklumat Kerosakan <span class="text-danger-600" aria-label="wajib">*</span>
                    </label>
                    <div class="relative">
                        <textarea id="damage_information"
                                  wire:model.live="damage_information"
                                  class="myds-textarea @error('damage_information') myds-input-error @enderror"
                                  rows="6"
                                  maxlength="{{ $maxCharacters }}"
                                  placeholder="Sila terangkan dengan terperinci mengenai kerosakan yang berlaku, termasuk:&#10;- Bila kerosakan mula berlaku&#10;- Apa yang berlaku sebelum kerosakan&#10;- Mesej ralat yang muncul (jika ada)&#10;- Langkah yang telah diambil untuk mengatasi masalah"
                                  aria-describedby="damage_information_error damage_information_hint damage_information_count"
                                  required></textarea>

                        <!-- Character Counter -->
                        <div class="flex justify-between items-center mt-2">
                            <p id="damage_information_hint" class="myds-field-hint">
                                Berikan butiran yang terperinci untuk membantu kami menyelesaikan masalah dengan cepat
                            </p>
                            <span id="damage_information_count"
                                  class="text-body-sm @if(strlen($damage_information) > $maxCharacters * 0.9) text-warning-600 @else text-txt-black-500 @endif"
                                  aria-live="polite">
                                {{ strlen($damage_information) }}/{{ $maxCharacters }}
                            </span>
                        </div>
                    </div>
                    @error('damage_information')
                        <div id="damage_information_error" class="myds-field-error" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </section>

        <!-- Section 3: Perakuan -->
        <section class="myds-panel myds-panel-success" aria-labelledby="declaration-heading">
            <h2 id="declaration-heading" class="text-heading-m font-medium text-txt-black-900 mb-6">
                3. Perakuan
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
                                <li>Saya memberikan kebenaran kepada MOTAC untuk memproses maklumat ini bagi tujuan penyelenggaraan dan pembaikan peralatan ICT.</li>
                                <li>Saya akan bekerjasama dengan pasukan teknikal dan menyediakan akses kepada peralatan yang bermasalah mengikut jadwal yang ditetapkan.</li>
                                <li>Saya memahami bahawa maklumat palsu boleh mengakibatkan tindakan disiplin diambil.</li>
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
                    Hantar Aduan
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

    <!-- Progress Indicator (Optional) -->
    <div class="mt-8 text-center">
        <div class="flex items-center justify-center space-x-2 text-body-sm text-txt-black-500">
            <svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
            </svg>
            <span>Maklumat anda dilindungi dan disulitkan</span>
        </div>
    </div>
</div>

<!-- Custom Styles for Form Elements -->
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
