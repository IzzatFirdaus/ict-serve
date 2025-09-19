<div class="min-h-screen bg-background-light">
  <div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
      <h1 class="font-poppins text-2xl font-semibold text-black-900">
        Borang Aduan Helpdesk ICT
      </h1>
      <p class="font-inter text-sm text-black-700 mt-2">
        Hantar permintaan untuk sokongan dan bantuan ICT
      </p>
    </div>
    <!-- Success Message -->
    @if (session('success'))
      <x-myds.callout variant="success" class="mb-6">
        <svg
          class="w-5 h-5 flex-shrink-0"
          fill="currentColor"
          viewBox="0 0 20 20"
        >
          <path
            fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
            clip-rule="evenodd"
          ></path>
        </svg>
        <div>
          <h4 class="font-inter text-sm font-medium">Aduan Berjaya Dihantar</h4>
          <p class="font-inter text-sm mt-1">
            {{ session('success') }}
          </p>
        </div>
      </x-myds.callout>
    @endif

    <!-- Error Message -->
    @if (session('error'))
      <x-myds.callout variant="danger" class="mb-6">
        <svg
          class="w-5 h-5 flex-shrink-0"
          fill="currentColor"
          viewBox="0 0 20 20"
        >
          <path
            fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"
          ></path>
        </svg>
        <div>
          <h4 class="font-inter text-sm font-medium">Ralat Berlaku</h4>
          <p class="font-inter text-sm mt-1">
            {{ session('error') }}
          </p>
        </div>
      </x-myds.callout>
    @endif

    <!-- Ticket Form -->
    <form
      wire:submit="submit"
      class="bg-white rounded-lg shadow-sm border border-divider"
    >
      <!-- Form Header -->
      <div class="px-6 py-4 border-b border-divider">
        <h2 class="font-poppins text-lg font-medium text-black-900">
          Maklumat Aduan
        </h2>
      </div>

      <div class="px-6 py-6 space-y-6">
        <!-- Category Selection -->
        <div>
          <x-myds.label for="category_id" required>Kategori</x-myds.label>
          <x-myds.select wire:model.blur="category_id" id="category_id">
            <option value="">Pilih kategori</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}">
                {{ $category->name }}
              </option>
            @endforeach
          </x-myds.select>
          <x-myds.error field="category_id" />
        </div>

        <!-- Title -->
        <div>
          <x-myds.label for="title" required>Tajuk Masalah</x-myds.label>
          <x-myds.input
            type="text"
            id="title"
            wire:model.blur="title"
            placeholder="Huraian ringkas mengenai masalah"
          />
          <x-myds.error field="title" />
        </div>

        <!-- Description -->
        <div>
          <x-myds.label for="description" required>
            Huraian Terperinci
          </x-myds.label>
          <x-myds.textarea
            id="description"
            wire:model.blur="description"
            rows="4"
            placeholder="Sila berikan maklumat terperinci mengenai masalah yang dihadapi"
          />
          <x-myds.error field="description" />
        </div>

        <!-- Priority and Urgency Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Priority -->
          <div>
            <x-myds.label for="priority" required>Keutamaan</x-myds.label>
            <x-myds.select wire:model.blur="priority" id="priority">
              <option value="">Pilih keutamaan</option>
              @foreach (\App\Enums\TicketPriority::cases() as $priorityOption)
                <option value="{{ $priorityOption->value }}">
                  {{ $priorityOption->label() }}
                </option>
              @endforeach
            </x-myds.select>
            @if ($priority)
              <p class="font-inter text-xs text-black-500 mt-1">
                {{ \App\Enums\TicketPriority::from($priority)->description() }}
              </p>
            @endif

            <x-myds.error field="priority" />
          </div>

          <!-- Urgency -->
          <div>
            <x-myds.label for="urgency" required>Kecemasan</x-myds.label>
            <x-myds.select wire:model.blur="urgency" id="urgency">
              <option value="">Pilih tahap kecemasan</option>
              @foreach (\App\Enums\TicketUrgency::cases() as $urgencyOption)
                <option value="{{ $urgencyOption->value }}">
                  {{ $urgencyOption->label() }}
                </option>
              @endforeach
            </x-myds.select>
            @if ($urgency)
              <p class="font-inter text-xs text-black-500 mt-1">
                {{ \App\Enums\TicketUrgency::from($urgency)->description() }}
              </p>
            @endif

            <x-myds.error field="urgency" />
          </div>
        </div>

        <!-- Equipment Selection -->
        @if (! empty($equipmentItems))
          <div>
            <x-myds.label for="equipment_item_id">
              {{ __('forms.labels.related_equipment_optional') }}
            </x-myds.label>
            <x-myds.select
              wire:model.blur="equipment_item_id"
              id="equipment_item_id"
            >
              <option value="">
                {{ __('forms.placeholders.no_specific_equipment') }}
              </option>
              @foreach ($equipmentItems as $equipment)
                <option value="{{ $equipment->id }}">
                  {{ $equipment->name }}
                  ({{ $equipment->serial_number ?? $equipment->asset_tag }})
                </option>
              @endforeach
            </x-myds.select>
            <x-myds.error field="equipment_item_id" />
          </div>
        @endif

        <!-- Location and Contact -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Location -->
          <div>
            <x-myds.label for="location" required>Lokasi</x-myds.label>
            <x-myds.input
              type="text"
              id="location"
              wire:model.blur="location"
              placeholder="Bangunan, tingkat, nombor bilik"
            />
            <x-myds.error field="location" />
          </div>

          <!-- Contact Phone -->
          <div>
            <x-myds.label for="contact_phone" required>
              Nombor Telefon
            </x-myds.label>
            <x-myds.input
              type="tel"
              id="contact_phone"
              wire:model.blur="contact_phone"
              placeholder="Nombor telefon untuk dihubungi"
            />
            <x-myds.error field="contact_phone" />
          </div>
        </div>

        <!-- File Attachments -->
        <div>
          <x-myds.label for="attachments">Lampiran (Pilihan)</x-myds.label>
          <div
            class="border-2 border-dashed border-divider rounded-lg p-6 text-center hover:border-primary-300 transition-colors"
          >
            <input
              type="file"
              wire:model="attachments"
              id="attachments"
              multiple
              accept="image/*,.pdf,.doc,.docx,.txt"
              class="hidden"
            />
            <label for="attachments" class="cursor-pointer">
              <svg
                class="w-8 h-8 text-black-400 mx-auto mb-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                ></path>
              </svg>
              <span class="font-inter text-sm text-black-600 block">
                Klik untuk muat naik fail atau seret dan lepas
              </span>
              <p class="font-inter text-xs text-black-500 mt-1">
                PNG, JPG, PDF, DOC sehingga 10MB setiap satu
              </p>
            </label>
          </div>

          <!-- Show selected files -->
          @if ($attachments)
            <div class="mt-4 space-y-2">
              @foreach ($attachments as $index => $attachment)
                <div
                  class="flex items-center justify-between bg-washed p-3 rounded-lg"
                >
                  <div class="flex items-center space-x-3">
                    <svg
                      class="w-4 h-4 text-black-500"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"
                      ></path>
                    </svg>
                    <span class="font-inter text-sm text-black-700">
                      {{ $attachment->getClientOriginalName() }}
                    </span>
                  </div>
                  <x-myds.button
                    variant="danger"
                    size="sm"
                    type="button"
                    wire:click="removeAttachment({{ $index }})"
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
                        d="M6 18L18 6M6 6l12 12"
                      ></path>
                    </svg>
                  </x-myds.button>
                </div>
              @endforeach
            </div>
          @endif

          <x-myds.error field="attachments.*" />
        </div>

        <!-- SLA Information -->
        @if ($priority && $urgency && method_exists($this, 'getSlaHours'))
          <x-myds.callout variant="info">
            <svg
              class="w-5 h-5 flex-shrink-0"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path
                fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                clip-rule="evenodd"
              ></path>
            </svg>
            <div>
              <h4 class="font-inter text-sm font-medium">
                Perjanjian Tahap Perkhidmatan
              </h4>
              <p class="font-inter text-sm mt-1">
                Berdasarkan keutamaan dan kecemasan yang dipilih, aduan ini akan
                diselesaikan dalam
                <strong>{{ $this->getSlaHours() }} jam</strong>
                semasa waktu perniagaan.
              </p>
            </div>
          </x-myds.callout>
        @endif
      </div>

      <!-- Form Actions -->
      <div
        class="px-6 py-4 border-t border-divider bg-washed rounded-b-lg flex justify-end space-x-4"
      >
        <x-myds.button
          variant="secondary"
          type="button"
          onclick="window.history.back()"
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
              d="M10 19l-7-7m0 0l7-7m-7 7h18"
            ></path>
          </svg>
          Batal
        </x-myds.button>

        <x-myds.button
          variant="primary"
          type="submit"
          wire:loading.attr="disabled"
        >
          <svg
            class="w-4 h-4 mr-2"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            wire:loading.remove
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 6v6m0 0v6m0-6h6m-6 0H6"
            ></path>
          </svg>
          <svg
            class="w-4 h-4 mr-2 animate-spin"
            fill="none"
            viewBox="0 0 24 24"
            wire:loading
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
          <span wire:loading.remove>Hantar Aduan</span>
          <span wire:loading>Menghantar...</span>
        </x-myds.button>
      </div>
    </form>
  </div>
</div>
