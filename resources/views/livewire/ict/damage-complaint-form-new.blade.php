@php
  $title = 'Borang Aduan Kerosakan ICT';
@endphp

<x-layouts.app :title="$title">
  <div class="myds-container max-w-4xl mx-auto py-8">
    <!-- Form Header -->
    <header class="mb-8">
      <div
        class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6"
      >
        <div>
          <h1
            class="font-heading text-heading-m font-semibold text-txt-black-900 dark:text-txt-black-900 mb-2"
          >
            Borang Aduan Kerosakan ICT
          </h1>
          <h2
            class="font-heading text-heading-2xs font-medium text-txt-black-700 dark:text-txt-black-700"
          >
            ICT Damage Complaint Form
          </h2>
        </div>
        <div class="flex items-center gap-3">
          <x-myds.tag variant="primary">
            {{ $formReference }}
          </x-myds.tag>
          <x-myds.tag variant="info">MYDS Compliant</x-myds.tag>
        </div>
      </div>

      <x-myds.callout variant="info">
        <p class="text-body-sm">
          Sila lengkapkan borang ini untuk mengadukan kerosakan peralatan ICT.
          Semua maklumat yang bertanda
          <span class="text-danger-600 dark:text-danger-400 font-medium">
            *
          </span>
          adalah wajib diisi. Aduan anda akan diproses dalam tempoh 3 hari
          bekerja.
        </p>
      </x-myds.callout>
    </header>

    <!-- Form -->
    <form
      wire:submit="submit"
      class="space-y-8"
      novalidate
      aria-label="Borang Aduan Kerosakan ICT"
      x-data="{
        currentStep: 1,
        totalSteps: 4,
        isSubmitting: false,
      }"
    >
      <!-- Progress Indicator -->
      <div class="relative mb-8">
        <div
          class="overflow-hidden h-2 text-xs flex rounded-full bg-bg-washed dark:bg-bg-washed"
        >
          <div
            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-primary-600 transition-all duration-300"
            :style="`width: ${(currentStep / totalSteps) * 100}%`"
          ></div>
        </div>
        <div
          class="flex justify-between text-body-xs text-txt-black-500 dark:text-txt-black-500 mt-2"
        >
          <span>Maklumat Pelapor</span>
          <span>Kerosakan</span>
          <span>Perakuan</span>
          <span>Selesai</span>
        </div>
      </div>

      <!-- Step 1: Reporter Information -->
      <x-myds.panel variant="default" x-show="currentStep === 1">
        <h2
          class="font-heading text-heading-s font-medium text-txt-black-900 dark:text-txt-black-900 mb-6 flex items-center"
        >
          <span
            class="bg-primary-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-body-sm font-medium mr-3"
          >
            1
          </span>
          Maklumat Pelapor
        </h2>

        <div class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Full Name -->
            <x-myds.input
              name="full_name"
              label="Nama Penuh"
              wire:model.blur="full_name"
              required
              placeholder="Contoh: Ahmad bin Ali"
              autocomplete="name"
            />

            <!-- Department -->
            <x-myds.select
              name="department"
              label="Bahagian"
              wire:model.live="department"
              required
              :options="$departments"
            />
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Position Grade -->
            <x-myds.input
              name="position_grade"
              label="Gred Jawatan"
              wire:model.blur="position_grade"
              placeholder="Contoh: N41, M41, JUSA"
            />

            <!-- Email -->
            <x-myds.input
              name="email"
              label="E-Mel"
              type="email"
              wire:model.blur="email"
              required
              placeholder="nama@motac.gov.my"
              autocomplete="email"
            />
          </div>

          <!-- Phone Number -->
          <x-myds.input
            name="phone"
            label="No. Telefon"
            type="tel"
            wire:model.blur="phone"
            required
            placeholder="Contoh: 03-1234567 atau 012-3456789"
            autocomplete="tel"
          />
        </div>

        <div class="flex justify-end mt-8">
          <x-myds.button
            type="button"
            variant="primary"
            @click="currentStep = 2"
            :disabled="!$this->canProceedToStep2"
          >
            Seterusnya
            <svg
              class="w-4 h-4 ml-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 5l7 7-7 7"
              ></path>
            </svg>
          </x-myds.button>
        </div>
      </x-myds.panel>

      <!-- Step 2: Damage Information -->
      <x-myds.panel variant="default" x-show="currentStep === 2">
        <h2
          class="font-heading text-heading-s font-medium text-txt-black-900 dark:text-txt-black-900 mb-6 flex items-center"
        >
          <span
            class="bg-primary-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-body-sm font-medium mr-3"
          >
            2
          </span>
          Maklumat Kerosakan
        </h2>

        <div class="space-y-6">
          <!-- Damage Type -->
          <x-myds.select
            name="damage_type_id"
            label="Jenis Kerosakan"
            wire:model.live="damage_type_id"
            required
            :options="$damageTypes"
          />

          <!-- Equipment Selection (if high priority) -->
          @if ($showEquipmentSelector)
            <div class="space-y-4">
              <h3
                class="font-heading text-heading-xs font-medium text-txt-black-900 dark:text-txt-black-900"
              >
                {{ __('forms.labels.damaged_equipment') }}
              </h3>
              <x-myds.select
                name="equipment_id"
                label="Pilih Peralatan"
                wire:model.live="equipment_id"
                required
                :options="$equipmentOptions"
              />
            </div>
          @endif

          <!-- Damage Description -->
          <x-myds.textarea
            name="damage_description"
            label="Penerangan Kerosakan"
            wire:model.blur="damage_description"
            required
            placeholder="Terangkan secara terperinci mengenai kerosakan yang dialami..."
            :maxlength="1000"
          />

          <!-- Location -->
          <x-myds.input
            name="location"
            label="Lokasi"
            wire:model.blur="location"
            required
            placeholder="Contoh: Bilik 204, Tingkat 2, Blok A"
          />

          <!-- Urgency Level (Auto-populated but editable) -->
          <div>
            <x-myds.select
              name="priority"
              label="Tahap Keutamaan"
              wire:model.live="priority"
              required
              :options="$priorities"
            />
            <p
              class="mt-1 text-body-xs text-txt-black-500 dark:text-txt-black-500"
            >
              Tahap keutamaan akan ditetapkan secara automatik berdasarkan jenis
              kerosakan yang dipilih.
            </p>
          </div>
        </div>

        <div class="flex justify-between mt-8">
          <x-myds.button
            type="button"
            variant="secondary"
            @click="currentStep = 1"
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
                d="M15 19l-7-7 7-7"
              ></path>
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
            <svg
              class="w-4 h-4 ml-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 5l7 7-7 7"
              ></path>
            </svg>
          </x-myds.button>
        </div>
      </x-myds.panel>

      <!-- Step 3: Declaration -->
      <x-myds.panel variant="warning" x-show="currentStep === 3">
        <h2
          class="font-heading text-heading-s font-medium text-txt-black-900 dark:text-txt-black-900 mb-6 flex items-center"
        >
          <span
            class="bg-warning-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-body-sm font-medium mr-3"
          >
            3
          </span>
          Perakuan dan Pengesahan
        </h2>

        <div class="space-y-6">
          <!-- Declaration -->
          <div
            class="bg-bg-white-0 dark:bg-bg-white-0 border border-otl-gray-200 dark:border-otl-gray-200 rounded-radius-m p-6"
          >
            <h3
              class="font-heading text-heading-xs font-medium text-txt-black-900 dark:text-txt-black-900 mb-4"
            >
              Perakuan Pelapor
            </h3>
            <div
              class="prose prose-sm text-txt-black-700 dark:text-txt-black-700 max-w-none"
            >
              <p>Saya dengan ini mengesahkan bahawa:</p>
              <ul class="list-disc list-inside space-y-1 mt-3">
                <li>Maklumat yang diberikan adalah benar dan tepat</li>
                <li>Kerosakan yang dilaporkan adalah benar berlaku</li>
                <li>
                  Saya bersetuju untuk dihubungi bagi tujuan pengesahan maklumat
                </li>
                <li>Aduan ini dibuat untuk tujuan rasmi dan bukan peribadi</li>
              </ul>
            </div>
          </div>

          <!-- Confirmation Checkbox -->
          <div
            class="flex items-start space-x-3 p-4 border border-danger-200 dark:border-danger-200 rounded-radius-m bg-danger-25 dark:bg-danger-25"
          >
            <input
              type="checkbox"
              id="confirmation"
              wire:model.live="confirmation"
              class="mt-1 h-4 w-4 text-primary-600 focus:ring-fr-primary border-otl-gray-300 rounded"
            />
            <label
              for="confirmation"
              class="text-body-sm text-txt-black-900 dark:text-txt-black-900 font-medium"
            >
              Saya mengesahkan bahawa semua maklumat yang diberikan adalah benar
              dan tepat. *
            </label>
          </div>
          @error('confirmation')
            <div
              class="text-danger-600 dark:text-danger-400 text-body-sm mt-1"
              role="alert"
            >
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="flex justify-between mt-8">
          <x-myds.button
            type="button"
            variant="secondary"
            @click="currentStep = 2"
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
                d="M15 19l-7-7 7-7"
              ></path>
            </svg>
            Kembali
          </x-myds.button>

          <x-myds.button
            type="button"
            variant="primary"
            @click="currentStep = 4"
            :disabled="!$confirmation"
          >
            Semak Semula
            <svg
              class="w-4 h-4 ml-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 5l7 7-7 7"
              ></path>
            </svg>
          </x-myds.button>
        </div>
      </x-myds.panel>

      <!-- Step 4: Review and Submit -->
      <x-myds.panel variant="success" x-show="currentStep === 4">
        <h2
          class="font-heading text-heading-s font-medium text-txt-black-900 dark:text-txt-black-900 mb-6 flex items-center"
        >
          <span
            class="bg-success-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-body-sm font-medium mr-3"
          >
            4
          </span>
          Semakan Terakhir
        </h2>

        <div class="space-y-6">
          <!-- Summary -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
              <h3
                class="font-heading text-heading-xs font-medium text-txt-black-900 dark:text-txt-black-900 border-b border-otl-gray-200 dark:border-otl-gray-200 pb-2"
              >
                Maklumat Pelapor
              </h3>
              <div class="space-y-2 text-body-sm">
                <div>
                  <strong>Nama:</strong>
                  {{ $full_name ?: '-' }}
                </div>
                <div>
                  <strong>Bahagian:</strong>
                  {{ $selectedDepartmentName ?: '-' }}
                </div>
                <div>
                  <strong>Gred:</strong>
                  {{ $position_grade ?: '-' }}
                </div>
                <div>
                  <strong>E-Mel:</strong>
                  {{ $email ?: '-' }}
                </div>
                <div>
                  <strong>Telefon:</strong>
                  {{ $phone ?: '-' }}
                </div>
              </div>
            </div>

            <div class="space-y-4">
              <h3
                class="font-heading text-heading-xs font-medium text-txt-black-900 dark:text-txt-black-900 border-b border-otl-gray-200 dark:border-otl-gray-200 pb-2"
              >
                Maklumat Kerosakan
              </h3>
              <div class="space-y-2 text-body-sm">
                <div>
                  <strong>Jenis:</strong>
                  {{ $selectedDamageTypeName ?: '-' }}
                </div>
                <div>
                  <strong>Keutamaan:</strong>
                  <x-myds.tag
                    :variant="$priority === 'high' ? 'danger' : ($priority === 'medium' ? 'warning' : 'success')"
                    size="sm"
                  >
                    {{ $priorityLabels[$priority] ?? '-' }}
                  </x-myds.tag>
                </div>
                <div>
                  <strong>Lokasi:</strong>
                  {{ $location ?: '-' }}
                </div>
                @if ($equipment_id)
                  <div>
                    <strong>Peralatan:</strong>
                    {{ $selectedEquipmentName ?: '-' }}
                  </div>
                @endif
              </div>
            </div>
          </div>

          <!-- Description -->
          <div>
            <h3
              class="font-heading text-heading-xs font-medium text-txt-black-900 dark:text-txt-black-900 border-b border-otl-gray-200 dark:border-otl-gray-200 pb-2 mb-3"
            >
              Penerangan Kerosakan
            </h3>
            <div
              class="bg-bg-washed dark:bg-bg-washed p-4 rounded-radius-m text-body-sm"
            >
              {{ $damage_description ?: 'Tiada penerangan diberikan' }}
            </div>
          </div>
        </div>

        <div class="flex justify-between mt-8">
          <x-myds.button
            type="button"
            variant="secondary"
            @click="currentStep = 3"
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
                d="M15 19l-7-7 7-7"
              ></path>
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
              Hantar Aduan
            </span>
            <span wire:loading wire:target="submit" class="flex items-center">
              <svg
                class="animate-spin -ml-1 mr-2 h-4 w-4"
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
      </x-myds.panel>
    </form>

    <!-- Success State -->
    @if (session()->has('success'))
      <div
        class="fixed inset-0 bg-gray-600/50 dark:bg-gray-900/50 flex items-center justify-center z-50"
        x-data="{ show: true }"
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
      >
        <div
          class="bg-bg-white-0 dark:bg-bg-white-0 rounded-radius-l shadow-context-menu p-8 max-w-md mx-4 text-center"
        >
          <div
            class="w-16 h-16 bg-success-100 dark:bg-success-100 rounded-full flex items-center justify-center mx-auto mb-4"
          >
            <svg
              class="w-8 h-8 text-success-600 dark:text-success-600"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 13l4 4L19 7"
              ></path>
            </svg>
          </div>
          <h2
            class="font-heading text-heading-s font-semibold text-txt-black-900 dark:text-txt-black-900 mb-2"
          >
            Aduan Berjaya Dihantar
          </h2>
          <p
            class="text-body-sm text-txt-black-700 dark:text-txt-black-700 mb-4"
          >
            {{ session('success') }}
          </p>
          <p
            class="text-body-xs text-txt-black-500 dark:text-txt-black-500 mb-6"
          >
            Rujukan:
            <strong>{{ session('reference_code') }}</strong>
          </p>
          <x-myds.button
            type="button"
            variant="primary"
            @click="show = false; window.location.href = '{{ route('dashboard') }}'"
          >
            Kembali ke Dashboard
          </x-myds.button>
        </div>
      </div>
    @endif
  </div>
</x-layouts.app>
