<div class="bg-background-light dark:bg-background-dark min-h-screen">
  <div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <x-myds.header>
      <h1
        class="font-poppins text-2xl font-semibold text-black-900 dark:text-white"
      >
        {{ __('forms.titles.loan_request') }}
      </h1>
      <p class="font-inter text-sm text-black-500 dark:text-black-400 mt-2">
        Sila lengkapkan maklumat berikut untuk memohon pinjaman peralatan ICT
      </p>
    </x-myds.header>

    <div class="max-w-4xl mx-auto">
      <!-- Success Message -->
      @if ($success_message)
        <x-myds.callout variant="success" class="mb-6">
          <x-myds.icon name="check-circle" size="20" class="flex-shrink-0" />
          <div>
            <h4
              class="font-inter text-sm font-medium text-success-700 dark:text-success-500"
            >
              Permohonan Berjaya Dihantar
            </h4>
            <p
              class="font-inter text-sm text-success-700 dark:text-success-500 mt-1"
            >
              {{ $success_message }}
            </p>
          </div>
        </x-myds.callout>
      @endif

      <!-- Error Message -->
      @if ($error_message)
        <x-myds.callout variant="danger" class="mb-6">
          <x-myds.icon name="warning-circle" size="20" class="flex-shrink-0" />
          <div>
            <h4
              class="font-inter text-sm font-medium text-danger-700 dark:text-danger-400"
            >
              Ralat Berlaku
            </h4>
            <p
              class="font-inter text-sm text-danger-700 dark:text-danger-400 mt-1"
            >
              {{ $error_message }}
            </p>
          </div>
        </x-myds.callout>
      @endif

      <!-- Application Form -->
      <form
        wire:submit="submit"
        class="bg-white dark:bg-dialog-active rounded-lg shadow-sm border border-divider"
      >
        <!-- Form Header -->
        <div class="px-6 py-4 border-b border-divider">
          <h2
            class="font-poppins text-lg font-medium text-black-900 dark:text-white"
          >
            Maklumat Permohonan
          </h2>
        </div>

        <div class="px-6 py-6 space-y-6">
          <!-- Purpose -->
          <div>
            <label
              for="purpose"
              class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2"
            >
              Tujuan Pinjaman
              <span class="text-danger-600">*</span>
            </label>
            <x-myds.input
              type="text"
              id="purpose"
              wire:model.live="purpose"
              placeholder="Nyatakan tujuan penggunaan peralatan ICT"
              class="w-full"
            />
            @error('purpose')
              <p class="font-inter text-xs text-danger-600 mt-1">
                {{ $message }}
              </p>
            @enderror
          </div>

          <!-- Location -->
          <div>
            <label
              for="location"
              class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2"
            >
              Lokasi Penggunaan
              <span class="text-danger-600">*</span>
            </label>
            <x-myds.input
              type="text"
              id="location"
              wire:model.live="location"
              placeholder="Nyatakan lokasi di mana peralatan akan digunakan"
              class="w-full"
            />
            @error('location')
              <p class="font-inter text-xs text-danger-600 mt-1">
                {{ $message }}
              </p>
            @enderror
          </div>

          <!-- Date Range -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label
                for="start_date"
                class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2"
              >
                Tarikh Mula
                <span class="text-danger-600">*</span>
              </label>
              <x-myds.input
                type="date"
                id="start_date"
                wire:model.live="start_date"
                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                class="w-full"
              />
              @error('start_date')
                <p class="font-inter text-xs text-danger-600 mt-1">
                  {{ $message }}
                </p>
              @enderror
            </div>

            <div>
              <label
                for="end_date"
                class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2"
              >
                Tarikh Tamat
                <span class="text-danger-600">*</span>
              </label>
              <x-myds.input
                type="date"
                id="end_date"
                wire:model.live="end_date"
                min="{{ $start_date ?: date('Y-m-d', strtotime('+2 days')) }}"
                class="w-full"
              />
              @error('end_date')
                <p class="font-inter text-xs text-danger-600 mt-1">
                  {{ $message }}
                </p>
              @enderror
            </div>
          </div>

          <!-- Equipment Selection -->
          <div>
            <label
              class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2"
            >
              Peralatan yang Diperlukan
              <span class="text-danger-600">*</span>
            </label>
            <div class="border border-divider rounded-lg p-4">
              @if (count($available_equipment_items) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                  @foreach ($available_equipment_items as $item)
                    <div class="flex items-center space-x-3">
                      <x-myds.checkbox
                        id="equipment_{{ $item['id'] }}"
                        wire:model.live="equipment_items"
                        value="{{ $item['id'] }}"
                      />
                      <label
                        for="equipment_{{ $item['id'] }}"
                        class="font-inter text-sm text-black-700 dark:text-black-300 cursor-pointer"
                      >
                        {{ $item['name'] }}
                        <span
                          class="text-black-500 dark:text-black-400 text-xs block"
                        >
                          {{ ucfirst($item['type']) }}
                        </span>
                      </label>
                    </div>
                  @endforeach
                </div>
              @else
                <p
                  class="font-inter text-sm text-black-500 dark:text-black-400 text-center py-4"
                >
                  Tiada peralatan tersedia pada masa ini.
                </p>
              @endif
            </div>
            @error('equipment_items')
              <p class="font-inter text-xs text-danger-600 mt-1">
                {{ $message }}
              </p>
            @enderror
          </div>

          <!-- Notes -->
          <div>
            <label
              for="notes"
              class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2"
            >
              Catatan Tambahan
            </label>
            <textarea
              id="notes"
              wire:model.live="notes"
              rows="4"
              placeholder="Sebarang maklumat tambahan yang diperlukan"
              class="font-inter text-sm w-full px-3 py-2 border border-divider rounded-lg bg-white dark:bg-dialog focus:ring focus:ring-primary-300 dark:focus:ring-primary-700 focus:border-primary-600 dark:focus:border-primary-400 resize-none"
            ></textarea>
            @error('notes')
              <p class="font-inter text-xs text-danger-600 mt-1">
                {{ $message }}
              </p>
            @enderror
          </div>

          <!-- Terms and Conditions -->
          <div>
            <div class="flex items-start space-x-3">
              <x-myds.checkbox
                id="terms_accepted"
                wire:model.live="terms_accepted"
                class="mt-1"
              />
              <label
                for="terms_accepted"
                class="font-inter text-sm text-black-700 dark:text-black-300 cursor-pointer"
              >
                Saya mengakui bahawa saya telah membaca dan memahami
                <a
                  href="#"
                  class="text-primary-600 hover:text-primary-700 underline"
                >
                  terma dan syarat
                </a>
                pinjaman peralatan ICT dan bersetuju untuk mematuhinya.
              </label>
            </div>
            @error('terms_accepted')
              <p class="font-inter text-xs text-danger-600 mt-1">
                {{ $message }}
              </p>
            @enderror
          </div>
        </div>

        <!-- Form Actions -->
        <div
          class="px-6 py-4 border-t border-divider bg-washed dark:bg-black-100 rounded-b-lg flex justify-end space-x-4"
        >
          <x-myds.button
            variant="secondary"
            type="button"
            onclick="window.history.back()"
          >
            <x-myds.icon name="arrow-left" size="16" class="mr-2" />
            Kembali
          </x-myds.button>

          <x-myds.button
            variant="primary"
            type="submit"
            :disabled="$submitting"
            wire:loading.attr="disabled"
          >
            <x-myds.icon
              name="plus"
              size="16"
              class="mr-2"
              wire:loading.remove
            />
            <x-myds.icon
              name="refresh"
              size="16"
              class="mr-2 animate-spin"
              wire:loading
            />
            <span wire:loading.remove>Hantar Permohonan</span>
            <span wire:loading>Menghantar...</span>
          </x-myds.button>
        </div>
      </form>
    </div>
  </div>
</div>
