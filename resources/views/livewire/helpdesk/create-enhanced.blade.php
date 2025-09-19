<div
  class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-indigo-900"
>
  <!-- Progress Indicator -->
  <div
    class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700"
  >
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <div class="flex items-center justify-between mb-4">
        <div>
          <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            Cipta Tiket Bantuan / Create Help Ticket
          </h1>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Langkah {{ $currentStep }} daripada {{ $maxSteps }} / Step
            {{ $currentStep }} of {{ $maxSteps }}
          </p>
        </div>

        <!-- Ticket Type Selector -->
        <div class="flex bg-gray-100 dark:bg-gray-700 rounded-lg p-1">
          <button
            type="button"
            wire:click="$set('ticketType', 'general')"
            class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ $ticketType === 'general' ? 'bg-white dark:bg-gray-800 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}"
          >
            Umum / General
          </button>
          <button
            type="button"
            wire:click="$set('ticketType', 'incident')"
            class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ $ticketType === 'incident' ? 'bg-white dark:bg-gray-800 text-red-600 dark:text-red-400 shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}"
          >
            Insiden / Incident
          </button>
          <button
            type="button"
            wire:click="$set('ticketType', 'damage')"
            class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ $ticketType === 'damage' ? 'bg-white dark:bg-gray-800 text-orange-600 dark:text-orange-400 shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}"
          >
            Kerosakan / Damage
          </button>
        </div>
      </div>

      <!-- Progress Bar -->
      <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
        <div
          class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2 rounded-full transition-all duration-300"
          style="width: {{ ($currentStep / $maxSteps) * 100 }}%"
        ></div>
      </div>

      <!-- Step Labels -->
      <div class="flex justify-between mt-3">
        <span
          class="text-xs {{ $currentStep >= 1 ? 'text-blue-600 dark:text-blue-400 font-medium' : 'text-gray-400' }}"
        >
          Jenis & Tajuk / Type & Title
        </span>
        <span
          class="text-xs {{ $currentStep >= 2 ? 'text-blue-600 dark:text-blue-400 font-medium' : 'text-gray-400' }}"
        >
          Butiran / Details
        </span>
        <span
          class="text-xs {{ $currentStep >= 3 ? 'text-blue-600 dark:text-blue-400 font-medium' : 'text-gray-400' }}"
        >
          Lampiran / Attachments
        </span>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div
      class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700"
    >
      <form wire:submit="submit">
        <div class="p-8">
          <!-- Step 1: Basic Information -->
          @if ($currentStep === 1)
            <div class="space-y-6" wire:key="step1">
              <div>
                <h2
                  class="text-lg font-semibold text-gray-900 dark:text-white mb-4"
                >
                  Maklumat Asas / Basic Information
                </h2>

                <!-- Title -->
                <div class="mb-6">
                  <label
                    for="title"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                  >
                    Tajuk / Title
                    <span class="text-red-500">*</span>
                  </label>
                  <input
                    type="text"
                    wire:model.live="title"
                    id="title"
                    class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors"
                    placeholder="Berikan tajuk yang jelas dan deskriptif / Provide a clear and descriptive title"
                  />
                  @error('title')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                      {{ $message }}
                    </p>
                  @enderror
                </div>

                <!-- Category -->
                <div>
                  <label
                    for="category_id"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                  >
                    Kategori / Category
                    <span class="text-red-500">*</span>
                  </label>
                  <select
                    wire:model.live="category_id"
                    id="category_id"
                    class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                  >
                    <option value="">Pilih kategori / Select category</option>
                    @foreach ($ticketCategories as $category)
                      <option value="{{ $category['id'] }}">
                        {{ $category['name'] }}
                      </option>
                    @endforeach
                  </select>
                  @error('category_id')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                      {{ $message }}
                    </p>
                  @enderror
                </div>
              </div>
            </div>
          @endif

          <!-- Step 2: Detailed Information -->
          @if ($currentStep === 2)
            <div class="space-y-6" wire:key="step2">
              <h2
                class="text-lg font-semibold text-gray-900 dark:text-white mb-4"
              >
                Butiran Terperinci / Detailed Information
              </h2>

              <!-- Description -->
              <div>
                <label
                  for="description"
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                >
                  Penerangan / Description
                  <span class="text-red-500">*</span>
                </label>
                <textarea
                  wire:model.live="description"
                  id="description"
                  rows="4"
                  class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                  placeholder="Huraikan masalah dengan terperinci / Describe the issue in detail"
                ></textarea>
                @error('description')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                  </p>
                @enderror
              </div>

              <!-- Priority & Urgency -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label
                    for="priority"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                  >
                    Keutamaan / Priority
                    <span class="text-red-500">*</span>
                  </label>
                  <select
                    wire:model.live="priority"
                    id="priority"
                    class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                  >
                    <option value="low">Rendah / Low</option>
                    <option value="medium">Sederhana / Medium</option>
                    <option value="high">Tinggi / High</option>
                    <option value="critical">Kritikal / Critical</option>
                  </select>
                </div>

                <div>
                  <label
                    for="urgency"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                  >
                    Kesegeraan / Urgency
                    <span class="text-red-500">*</span>
                  </label>
                  <select
                    wire:model.live="urgency"
                    id="urgency"
                    class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                  >
                    <option value="low">Rendah / Low</option>
                    <option value="normal">Normal / Normal</option>
                    <option value="high">Tinggi / High</option>
                    <option value="urgent">Segera / Urgent</option>
                  </select>
                </div>
              </div>

              <!-- Location & Contact -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label
                    for="location"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                  >
                    Lokasi / Location
                    <span class="text-red-500">*</span>
                  </label>
                  <input
                    type="text"
                    wire:model.live="location"
                    id="location"
                    class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                  />
                  @error('location')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                      {{ $message }}
                    </p>
                  @enderror
                </div>

                <div>
                  <label
                    for="contact_phone"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                  >
                    Nombor Telefon / Phone Number
                    <span class="text-red-500">*</span>
                  </label>
                  <input
                    type="tel"
                    wire:model.live="contact_phone"
                    id="contact_phone"
                    class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                  />
                  @error('contact_phone')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                      {{ $message }}
                    </p>
                  @enderror
                </div>
              </div>

              <!-- Type-specific fields -->
              @if ($ticketType === 'incident')
                @include('livewire.helpdesk.partials.incident-fields')
              @elseif ($ticketType === 'damage')
                @include('livewire.helpdesk.partials.damage-fields')
              @endif
            </div>
          @endif

          <!-- Step 3: Equipment & Attachments -->
          @if ($currentStep === 3)
            <div class="space-y-6" wire:key="step3">
              <h2
                class="text-lg font-semibold text-gray-900 dark:text-white mb-4"
              >
                {{ __('forms.sections.equipment_attachments') }}
              </h2>

              <!-- Equipment Selection -->
              @if ($showEquipmentSelector)
                <div>
                  <label
                    for="equipment_item_id"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                  >
                    {{ __('forms.labels.equipment_item') }}
                  </label>
                  <select
                    wire:model.live="equipment_item_id"
                    id="equipment_item_id"
                    class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                  >
                    <option value="">
                      {{ __('forms.placeholders.select_equipment_item') }}
                    </option>
                    @foreach ($equipmentItems as $item)
                      <option value="{{ $item['id'] }}">
                        {{ $item['brand'] }} {{ $item['model'] }}
                        @if (isset($item['category']['name']))
                            - {{ $item['category']['name'] }}
                        @endif
                      </option>
                    @endforeach
                  </select>
                  @error('equipment_item_id')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                      {{ $message }}
                    </p>
                  @enderror
                </div>
              @endif

              <!-- File Attachments -->
              <div>
                <label
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                >
                  Lampiran Fail / File Attachments
                  <span class="text-gray-500 text-xs">
                    (Maks 5 fail, 10MB setiap satu / Max 5 files, 10MB each)
                  </span>
                </label>

                <div
                  class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 hover:border-blue-400 dark:hover:border-blue-500 transition-colors"
                >
                  <input
                    type="file"
                    wire:model="attachments"
                    id="attachments"
                    multiple
                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt"
                    class="hidden"
                  />
                  <label
                    for="attachments"
                    class="cursor-pointer block text-center"
                  >
                    <svg
                      class="w-10 h-10 mx-auto text-gray-400 mb-2"
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
                    <span class="text-blue-600 dark:text-blue-400 font-medium">
                      Klik untuk memuat naik fail
                    </span>
                    <p class="text-gray-500 text-sm mt-1">
                      atau seret dan lepas fail di sini / or drag and drop files
                      here
                    </p>
                  </label>
                </div>

                <!-- File List -->
                @if ($attachments)
                  <div class="mt-4 space-y-2">
                    @foreach ($attachments as $index => $attachment)
                      <div
                        class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg"
                      >
                        <div class="flex items-center space-x-2">
                          <svg
                            class="w-5 h-5 text-blue-500"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            ></path>
                          </svg>
                          <span
                            class="text-sm text-gray-700 dark:text-gray-300"
                          >
                            {{ $attachment->getClientOriginalName() }}
                          </span>
                          <span class="text-xs text-gray-500">
                            ({{ number_format($attachment->getSize() / 1024, 1) }}KB)
                          </span>
                        </div>
                        <button
                          type="button"
                          wire:click="removeAttachment({{ $index }})"
                          class="text-red-500 hover:text-red-700 transition-colors"
                        >
                          <svg
                            class="w-5 h-5"
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
                        </button>
                      </div>
                    @endforeach
                  </div>
                @endif

                @error('attachments.*')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                  </p>
                @enderror
              </div>
            </div>
          @endif
        </div>

        <!-- Navigation Buttons -->
        <div
          class="bg-gray-50 dark:bg-gray-700 px-8 py-6 border-t border-gray-200 dark:border-gray-600 rounded-b-xl"
        >
          <div class="flex justify-between">
            <!-- Previous Button -->
            @if ($currentStep > 1)
              <button
                type="button"
                wire:click="previousStep"
                class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
              >
                <svg
                  class="w-5 h-5 mr-2"
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
                Kembali / Back
              </button>
            @else
              <div></div>
            @endif

            <!-- Next/Submit Button -->
            @if ($currentStep < $maxSteps)
              <button
                type="button"
                wire:click="nextStep"
                class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all"
              >
                Seterusnya / Next
                <svg
                  class="w-5 h-5 ml-2"
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
              </button>
            @else
              <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="submit"
                class="inline-flex items-center px-8 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 transition-all"
              >
                <span wire:loading.remove wire:target="submit">
                  <svg
                    class="w-5 h-5 mr-2"
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
                  Hantar Tiket / Submit Ticket
                </span>
                <span
                  wire:loading
                  wire:target="submit"
                  class="flex items-center"
                >
                  <svg
                    class="animate-spin -ml-1 mr-2 h-5 w-5"
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
                  Menghantar... / Submitting...
                </span>
              </button>
            @endif
          </div>
        </div>
      </form>
    </div>

    <!-- Help Section -->
    <div
      class="mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6"
    >
      <div class="flex items-start space-x-3">
        <svg
          class="w-6 h-6 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
          ></path>
        </svg>
        <div>
          <h3 class="text-sm font-medium text-blue-900 dark:text-blue-100 mb-1">
            Petua / Tips
          </h3>
          @if ($ticketType === 'incident')
            <p class="text-sm text-blue-800 dark:text-blue-200">
              Untuk laporan insiden, sertakan masa tepat kejadian, saksi (jika
              ada), dan tindakan segera yang telah diambil. / For incident
              reports, include exact time of occurrence, witnesses (if any), and
              immediate actions taken.
            </p>
          @elseif ($ticketType === 'damage')
            <p class="text-sm text-blue-800 dark:text-blue-200">
              Untuk laporan kerosakan, nyatakan jenis kerosakan, punca yang
              disyaki, dan status waranti peralatan. / For damage reports,
              specify damage type, suspected cause, and equipment warranty
              status.
            </p>
          @else
            <p class="text-sm text-blue-800 dark:text-blue-200">
              Berikan penerangan yang jelas dan terperinci untuk membantu kami
              menyelesaikan masalah anda dengan cepat. / Provide clear and
              detailed descriptions to help us resolve your issue quickly.
            </p>
          @endif
        </div>
      </div>
    </div>
  </div>

  @if (session('success'))
    <div
      wire:key="success-message"
      class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg"
      x-data="{ show: true }"
      x-show="show"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0 transform translate-x-full"
      x-transition:enter-end="opacity-100 transform translate-x-0"
      x-transition:leave="transition ease-in duration-300"
      x-transition:leave-start="opacity-100 transform translate-x-0"
      x-transition:leave-end="opacity-0 transform translate-x-full"
      x-init="setTimeout(() => (show = false), 5000)"
    >
      <div class="flex items-center space-x-2">
        <svg
          class="w-6 h-6"
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
        <span>{{ session('success') }}</span>
      </div>
    </div>
  @endif
</div>
