<div class="max-w-6xl mx-auto py-8">
  <!-- Form Header -->
  <div class="mb-8">
    <div class="flex items-center justify-between mb-4">
      <h1 class="font-poppins text-2xl font-semibold text-black-900">
        Borang Permohonan Pinjaman Peralatan ICT
      </h1>
      <span
        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800"
      >
        {{ $formReference }}
      </span>
    </div>
    <p class="font-inter text-sm text-black-700">
      Sila lengkapkan borang ini untuk memohon pinjaman peralatan ICT. Semua
      maklumat yang bertanda
      <span class="text-danger-600">*</span>
      adalah wajib diisi.
    </p>
  </div>

  <!-- Form Progress Indicator -->
  <div class="mb-8">
    <div class="flex items-center justify-between text-sm">
      <div class="flex items-center space-x-2">
        <div
          class="w-6 h-6 bg-primary-600 text-white rounded-full flex items-center justify-center font-medium"
        >
          1
        </div>
        <span class="text-black-700">Maklumat Pemohon</span>
      </div>
      <div class="flex-1 h-px bg-divider mx-4"></div>
      <div class="flex items-center space-x-2">
        <div
          class="w-6 h-6 bg-primary-600 text-white rounded-full flex items-center justify-center font-medium"
        >
          2
        </div>
        <span class="text-black-700">Pegawai Bertanggungjawab</span>
      </div>
      <div class="flex-1 h-px bg-divider mx-4"></div>
      <div class="flex items-center space-x-2">
        <div
          class="w-6 h-6 bg-primary-600 text-white rounded-full flex items-center justify-center font-medium"
        >
          3
        </div>
        <span class="text-black-700">Maklumat Peralatan</span>
      </div>
      <div class="flex-1 h-px bg-divider mx-4"></div>
      <div class="flex items-center space-x-2">
        <div
          class="w-6 h-6 bg-primary-600 text-white rounded-full flex items-center justify-center font-medium"
        >
          4
        </div>
        <span class="text-black-700">Perakuan</span>
      </div>
    </div>
  </div>

  <!-- Form -->
  <form
    wire:submit="submit"
    class="space-y-8"
    novalidate
    aria-label="Borang Permohonan Pinjaman Peralatan ICT"
  >
    <!-- Part 1: Applicant Information -->
    <section
      class="bg-white rounded-lg border border-divider p-6"
      aria-labelledby="applicant-info-heading"
    >
      <h2
        id="applicant-info-heading"
        class="font-poppins text-lg font-medium text-black-900 mb-6"
      >
        Bahagian 1: Maklumat Pemohon
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Applicant Name -->
        <div>
          <x-myds.label for="applicant_name" required>Nama Penuh</x-myds.label>
          <x-myds.input
            type="text"
            id="applicant_name"
            wire:model.blur="applicant_name"
            placeholder="Contoh: Ahmad bin Ali"
            required
          />
          <x-myds.error field="applicant_name" />
        </div>

        <!-- Applicant Position -->
        <div>
          <x-myds.label for="applicant_position" required>Jawatan</x-myds.label>
          <x-myds.input
            type="text"
            id="applicant_position"
            wire:model.blur="applicant_position"
            placeholder="Contoh: Penolong Pegawai Teknologi Maklumat"
            required
          />
          <x-myds.error field="applicant_position" />
        </div>

        <!-- Applicant Division -->
        <div>
          <x-myds.label for="applicant_division" required>
            Bahagian
          </x-myds.label>
          <x-myds.select
            id="applicant_division"
            wire:model.blur="applicant_division"
            required
          >
            <option value="">Pilih Bahagian</option>
            @foreach ($divisions as $div)
              <option value="{{ $div }}">{{ $div }}</option>
            @endforeach
          </x-myds.select>
          <x-myds.error field="applicant_division" />
        </div>

        <!-- Applicant Grade -->
        <div>
          <x-myds.label for="applicant_grade">Gred Jawatan</x-myds.label>
          <x-myds.input
            type="text"
            id="applicant_grade"
            wire:model.blur="applicant_grade"
            placeholder="Contoh: N41, M48, JUSA C"
            maxlength="10"
          />
          <p class="text-xs text-black-500 mt-1">Pilihan - Jika berkenaan</p>
        </div>

        <!-- Applicant Email -->
        <div>
          <x-myds.label for="applicant_email" required>
            Alamat E-mel
          </x-myds.label>
          <x-myds.input
            type="email"
            id="applicant_email"
            wire:model.blur="applicant_email"
            placeholder="contoh@motac.gov.my"
            required
          />
          <x-myds.error field="applicant_email" />
        </div>

        <!-- Applicant Phone -->
        <div>
          <x-myds.label for="applicant_phone" required>
            Nombor Telefon
          </x-myds.label>
          <x-myds.input
            type="tel"
            id="applicant_phone"
            wire:model.blur="applicant_phone"
            placeholder="Contoh: +60123456789 atau 0123456789"
            required
          />
          <x-myds.error field="applicant_phone" />
        </div>
      </div>
    </section>

    <!-- Part 2: Responsible Officer Information -->
    <section
      class="bg-white rounded-lg border border-divider p-6"
      aria-labelledby="officer-info-heading"
    >
      <h2
        id="officer-info-heading"
        class="font-poppins text-lg font-medium text-black-900 mb-6"
      >
        Bahagian 2: Maklumat Pegawai Bertanggungjawab
      </h2>

      <!-- Same as Applicant Checkbox -->
      <div class="mb-6">
        <x-myds.checkbox
          id="same_as_applicant"
          wire:model.live="same_as_applicant"
          value="1"
          label="Sama seperti maklumat pemohon"
        />
        <p class="text-xs text-black-500 mt-2">
          Tandakan jika pegawai bertanggungjawab adalah sama dengan pemohon
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Officer Name -->
        <div>
          <x-myds.label for="officer_name" required>Nama Penuh</x-myds.label>
          <x-myds.input
            type="text"
            id="officer_name"
            wire:model.blur="officer_name"
            placeholder="Contoh: Ahmad bin Ali"
            :disabled="$same_as_applicant"
            required
          />
          <x-myds.error field="officer_name" />
        </div>

        <!-- Officer Position -->
        <div>
          <x-myds.label for="officer_position" required>Jawatan</x-myds.label>
          <x-myds.input
            type="text"
            id="officer_position"
            wire:model.blur="officer_position"
            placeholder="Contoh: Pegawai Teknologi Maklumat"
            :disabled="$same_as_applicant"
            required
          />
          <x-myds.error field="officer_position" />
        </div>

        <!-- Officer Division -->
        <div>
          <x-myds.label for="officer_division" required>Bahagian</x-myds.label>
          <x-myds.select
            id="officer_division"
            wire:model.blur="officer_division"
            :disabled="$same_as_applicant"
            required
          >
            <option value="">Pilih Bahagian</option>
            @foreach ($divisions as $div)
              <option value="{{ $div }}">{{ $div }}</option>
            @endforeach
          </x-myds.select>
          <x-myds.error field="officer_division" />
        </div>

        <!-- Officer Grade -->
        <div>
          <x-myds.label for="officer_grade">Gred Jawatan</x-myds.label>
          <x-myds.input
            type="text"
            id="officer_grade"
            wire:model.blur="officer_grade"
            placeholder="Contoh: N41, M48, JUSA C"
            maxlength="10"
            :disabled="$same_as_applicant"
          />
          <p class="text-xs text-black-500 mt-1">Pilihan - Jika berkenaan</p>
        </div>

        <!-- Officer Email -->
        <div>
          <x-myds.label for="officer_email" required>Alamat E-mel</x-myds.label>
          <x-myds.input
            type="email"
            id="officer_email"
            wire:model.blur="officer_email"
            placeholder="contoh@motac.gov.my"
            :disabled="$same_as_applicant"
            required
          />
          <x-myds.error field="officer_email" />
        </div>

        <!-- Officer Phone -->
        <div>
          <x-myds.label for="officer_phone" required>
            Nombor Telefon
          </x-myds.label>
          <x-myds.input
            type="tel"
            id="officer_phone"
            wire:model.blur="officer_phone"
            placeholder="Contoh: +60123456789 atau 0123456789"
            :disabled="$same_as_applicant"
            required
          />
          <x-myds.error field="officer_phone" />
        </div>
      </div>
    </section>

    <!-- Part 3: Equipment Information -->
    <section
      class="bg-white rounded-lg border border-divider p-6"
      aria-labelledby="equipment-info-heading"
    >
      <h2
        id="equipment-info-heading"
        class="font-poppins text-lg font-medium text-black-900 mb-6"
      >
        Bahagian 3: Maklumat Peralatan dan Tempoh Pinjaman
      </h2>

      <!-- Loan Period -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Start Date -->
        <div>
          <x-myds.label for="loan_start_date" required>
            Tarikh Mula Pinjaman
          </x-myds.label>
          <x-myds.input
            type="date"
            id="loan_start_date"
            wire:model.blur="loan_start_date"
            min="{{ date('Y-m-d', strtotime('+1 day')) }}"
            required
          />
          <x-myds.error field="loan_start_date" />
        </div>

        <!-- End Date -->
        <div>
          <x-myds.label for="loan_end_date" required>
            Tarikh Tamat Pinjaman
          </x-myds.label>
          <x-myds.input
            type="date"
            id="loan_end_date"
            wire:model.blur="loan_end_date"
            min="{{ $loan_start_date ?: date('Y-m-d', strtotime('+2 days')) }}"
            required
          />
          <x-myds.error field="loan_end_date" />
        </div>

        <!-- Purpose -->
        <div class="md:col-span-2">
          <x-myds.label for="loan_purpose" required>
            Tujuan Pinjaman
          </x-myds.label>
          <x-myds.textarea
            id="loan_purpose"
            wire:model.blur="loan_purpose"
            rows="3"
            maxlength="500"
            placeholder="Contoh: Untuk persembahan projek di mesyuarat bulanan, kursus latihan, dll."
            required
          />
          <p class="text-xs text-black-500 mt-1">
            Nyatakan dengan jelas tujuan pinjaman peralatan (Maksimum 500
            aksara)
          </p>
          <x-myds.error field="loan_purpose" />
        </div>
      </div>

      <!-- Equipment Requests Table -->
      <div class="space-y-4">
        <div class="flex items-center justify-between">
          <h3 class="font-poppins text-base font-medium text-black-900">
            Senarai Peralatan Diperlukan
          </h3>
          <x-myds.button
            type="button"
            variant="secondary"
            size="sm"
            wire:click="addEquipmentRow"
          >
            <svg
              class="w-4 h-4 mr-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 6v6m0 0v6m0-6h6m-6 0H6"
              ></path>
            </svg>
            {{ __('buttons.add_equipment') }}
          </x-myds.button>
        </div>

        <!-- Equipment Requests -->
        <div class="space-y-4">
          @foreach ($this->equipmentRequests as $index => $request)
            <div
              class="border border-divider rounded-lg p-4"
              wire:key="equipment-{{ $index }}"
            >
              <div class="flex items-start justify-between mb-4">
                <h4 class="font-inter text-sm font-medium text-black-900">
                  {{ __('literals.equipment') }} {{ $index + 1 }}
                </h4>
                @if (count($this->equipmentRequests) > 1)
                  <button
                    type="button"
                    wire:click="removeEquipmentRow({{ $index }})"
                    class="text-danger-600 hover:text-danger-700 p-1 rounded focus:outline-none focus:ring-2 focus:ring-danger-300"
                  >
                    <svg
                      class="w-4 h-4"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                      ></path>
                    </svg>
                  </button>
                @endif
              </div>

              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Equipment Selection -->
                <div>
                  <x-myds.label
                    for="equipment_requests.{{ $index }}.equipment_id"
                    required
                  >
                    {{ __('forms.labels.select_equipment') }}
                  </x-myds.label>
                  <x-myds.select
                    wire:model.blur="equipment_requests.{{ $index }}.equipment_id"
                    required
                  >
                    <option value="">
                      {{ __('forms.placeholders.select_equipment') }}
                    </option>
                    @foreach ($equipmentTypes as $key => $equipmentName)
                      <option value="{{ $key }}">
                        {{ $equipmentName }}
                      </option>
                    @endforeach
                  </x-myds.select>
                  <x-myds.error
                    field="equipment_requests.{{ $index }}.equipment_id"
                  />
                </div>

                <!-- Quantity -->
                <div>
                  <x-myds.label
                    for="equipment_requests.{{ $index }}.quantity"
                    required
                  >
                    Kuantiti
                  </x-myds.label>
                  <x-myds.input
                    type="number"
                    wire:model.blur="equipment_requests.{{ $index }}.quantity"
                    min="1"
                    max="10"
                    required
                  />
                  <x-myds.error
                    field="equipment_requests.{{ $index }}.quantity"
                  />
                </div>

                <!-- Remarks -->
                <div>
                  <x-myds.label for="equipment_requests.{{ $index }}.remarks">
                    Catatan
                  </x-myds.label>
                  <x-myds.input
                    type="text"
                    wire:model.blur="equipment_requests.{{ $index }}.remarks"
                    placeholder="Keperluan khas (jika ada)"
                    maxlength="255"
                  />
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <x-myds.error field="equipment_requests" />
      </div>
    </section>

    <!-- Part 4: Declaration -->
    <section
      class="bg-white rounded-lg border border-divider p-6"
      aria-labelledby="declaration-heading"
    >
      <h2
        id="declaration-heading"
        class="font-poppins text-lg font-medium text-black-900 mb-6"
      >
        Bahagian 4: Perakuan
      </h2>

      <div>
        <div
          class="bg-washed p-4 rounded-lg border-l-4 border-primary-600 mb-4"
        >
          <p class="font-inter text-sm text-black-700 mb-3">
            <strong>Saya dengan ini mengaku dan mengesahkan bahawa:</strong>
          </p>
          <ol
            class="list-decimal list-inside space-y-2 ml-4 font-inter text-sm text-black-700 leading-relaxed"
          >
            <li>
              Semua maklumat yang diberikan dalam borang ini adalah benar dan
              tepat.
            </li>
            <li>
              Saya akan menggunakan peralatan yang dipinjam dengan
              bertanggungjawab dan hanya untuk tujuan rasmi yang dinyatakan.
            </li>
            <li>
              Saya akan memulangkan peralatan dalam keadaan baik dan pada tarikh
              yang ditetapkan.
            </li>
            <li>
              Saya bertanggungjawab sepenuhnya ke atas sebarang kerosakan atau
              kehilangan peralatan semasa tempoh pinjaman.
            </li>
            <li>
              Saya akan melaporkan dengan segera sebarang kerosakan atau masalah
              yang berlaku pada peralatan.
            </li>
            <li>
              Saya memahami bahawa pelanggaran terhadap syarat-syarat ini boleh
              mengakibatkan tindakan disiplin dan sekatan pinjaman pada masa
              akan datang.
            </li>
          </ol>
        </div>

        <x-myds.checkbox
          id="declaration_accepted"
          wire:model.blur="declaration_accepted"
          value="1"
          label="Saya bersetuju dengan perakuan di atas"
          required
        />
        <x-myds.error field="declaration_accepted" />
      </div>
    </section>

    <!-- Form Actions -->
    <div
      class="flex flex-col sm:flex-row gap-4 justify-end pt-6 border-t border-divider"
    >
      <x-myds.button
        type="button"
        variant="secondary"
        onclick="if(confirm('Adakah anda pasti mahu membatalkan? Semua data yang dimasukkan akan hilang.')) {
                    window.history.back();
                }"
      >
        <svg
          class="w-4 h-4 mr-2"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
          ></path>
        </svg>
        Batal
      </x-myds.button>

      <x-myds.button
        type="submit"
        variant="primary"
        wire:loading.attr="disabled"
        wire:target="submit"
      >
        <span wire:loading.remove wire:target="submit">
          <svg
            class="w-4 h-4 mr-2"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
            ></path>
          </svg>
          Hantar Permohonan
        </span>
        <span wire:loading wire:target="submit" class="flex items-center">
          <svg
            class="animate-spin -ml-1 mr-3 h-4 w-4"
            fill="none"
            viewBox="0 0 24 24"
          >
            <circle
              class="opacity-25"
              cx="12"
              cy="12"
              r="10"
              stroke="currentColor"
              stroke-width="4"
            ></circle>
            <path
              class="opacity-75"
              fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
            ></path>
          </svg>
          Menghantar...
        </span>
      </x-myds.button>
    </div>
  </form>

  <!-- Security Notice -->
  <div class="mt-8 text-center">
    <div
      class="flex items-center justify-center space-x-2 font-inter text-sm text-black-500"
    >
      <svg
        class="w-4 h-4 text-primary-600"
        fill="currentColor"
        viewBox="0 0 20 20"
      >
        <path
          fill-rule="evenodd"
          d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
          clip-rule="evenodd"
        ></path>
      </svg>
      <span>Maklumat anda dilindungi dan disulitkan</span>
    </div>
  </div>
</div>
