<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
  <!-- Page Header -->
  <div class="mb-6">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="Breadcrumb" class="mb-4">
      <ol class="flex items-center space-x-2 text-sm">
        <li>
          <a href="{{ route('dashboard') }}" class="text-primary-600 hover:text-primary-800">
            Papan Pemuka / Dashboard
          </a>
        </li>
        <li class="text-gray-500">/</li>
        <li>
          <a href="{{ route('helpdesk.index') }}" class="text-primary-600 hover:text-primary-800">
            Bantuan Teknikal / Technical Support
          </a>
        </li>
        <li class="text-gray-500">/</li>
        <li
          class="text-gray-900 font-medium"
          aria-current="page"
        >
          Lapor Masalah / Report Issue
        </li>
      </ol>
    </nav>

    <!-- Page Title -->
    <div class="mb-6">
      <h1 class="text-3xl font-bold font-poppins text-gray-900 dark:text-gray-100 flex items-center">
        <x-myds.icon name="exclamation-triangle" size="24" class="mr-3" aria-hidden="true" />
        Lapor Masalah Teknikal
      </h1>
      <p
        class="text-lg font-inter text-gray-600 dark:text-gray-400 mt-2"
      >
        Report Technical Issue
      </p>
      <p
        class="text-base text-gray-600 dark:text-gray-400 mt-4"
      >
        Sila lengkapkan borang di bawah untuk melaporkan masalah teknikal atau
        meminta bantuan ICT.
        <br />
        Please complete the form below to report technical issues or request ICT
        assistance.
      </p>
    </div>
  </div>

  <form wire:submit.prevent="submit" class="space-y-8">
    @csrf

    <!-- Issue Details Section -->
    <div class="bg-white rounded-lg shadow border border-gray-200 dark:bg-gray-900 dark:border-gray-800">
      <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
        <h2 class="text-xl font-semibold font-poppins text-gray-900 dark:text-gray-100 flex items-center">
          <x-myds.icon name="clipboard-list" size="20" class="mr-2" aria-hidden="true" />
          Butiran Masalah / Issue Details
        </h2>
      </div>

      <div class="px-6 py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Issue Title -->
          <div class="col-span-1">
            <x-myds.form-input
              label="Tajuk Masalah / Issue Title"
              id="title"
              name="title"
              wire:model="title"
              placeholder="Nyatakan masalah secara ringkas... / Brief description of the issue..."
              maxlength="255"
              required
              helper="Berikan tajuk yang jelas untuk masalah anda. / Provide a clear title for your issue."
              error="{{ $errors->first('title') }}"
            />
          </div>

          <!-- Issue Category -->
          <div class="col-span-1">
            <x-myds.form-select
              id="category_id"
              label="Kategori Masalah / Issue Category"
              name="category_id"
              wire:model.live="category_id"
              required
              error="{{ $errors->first('category_id') }}"
            >
              <option value="">Pilih kategori... / Select category...</option>
              @foreach ($ticketCategories as $category)
                <option value="{{ $category['id'] }}">{{ $category['name'] }} / {{ $category['name_bm'] }}</option>
              @endforeach
            </x-myds.form-select>
          </div>

          <!-- Priority Level -->
          <div class="col-span-1">
            <x-myds.form-select
              id="priority"
              label="Tahap Keutamaan / Priority Level"
              name="priority"
              wire:model="priority"
              required
              error="{{ $errors->first('priority') }}"
            >
              <option value="low">Rendah / Low - Tidak mengganggu kerja / Not affecting work</option>
              <option value="medium" selected>Sederhana / Medium - Mengganggu sedikit / Slightly affecting work</option>
              <option value="high">Tinggi / High - Mengganggu kerja / Affecting work significantly</option>
              <option value="critical">Kritikal / Critical - Menghentikan kerja / Stopping work completely</option>
            </x-myds.form-select>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Pilih tahap keutamaan berdasarkan kesan terhadap kerja anda. / Select priority level based on impact on your work.</p>
          </div>

          <!-- Issue Description -->
          <div class="col-span-2">
            <x-myds.form-textarea
              id="description"
              name="description"
              label="Penerangan Masalah / Issue Description"
              wire:model="description"
              rows="5"
              placeholder="Terangkan masalah dengan terperinci termasuk: - Apa yang berlaku? - Bila masalah bermula? - Langkah-langkah yang telah dicuba? Explain the issue in detail including: - What happened? - When did the issue start? - Steps already tried?"
              maxlength="2000"
              required
              error="{{ $errors->first('description') }}"
            />
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Berikan penerangan yang terperinci untuk membantu kami memahami masalah. / Provide detailed description to help us understand the issue.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Equipment Information Section (conditional) -->
    @if ($showEquipmentSelector)
      <div class="bg-white rounded-lg shadow p-6 space-y-6">
        <div class="flex items-center">
          <x-myds.icon name="desktop-computer" class="mr-2 text-gray-600" aria-hidden="true" />
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
            Maklumat Peralatan / Equipment Information
          </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Equipment Selection -->
            <div class="col-span-2">
              <x-myds.form-select
                id="equipment_item_id"
                name="equipment_item_id"
                label="{{ __('forms.labels.related_equipment') }}"
                wire:model="equipment_item_id"
                error="{{ $errors->first('equipment_item_id') }}"
              >
                <option value="">{{ __('forms.placeholders.select_related_equipment') }}</option>
                @foreach ($equipmentItems as $item)
                  <option value="{{ $item['id'] }}">{{ $item['brand'] }} {{ $item['model'] }}@if(! empty($item['serial_number'])) (S/N: {{ $item['serial_number'] }})@endif</option>
                @endforeach
              </x-myds.form-select>
              <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Pilih peralatan yang berkaitan dengan masalah ini (jika ada). / Select equipment related to this issue (if any).</p>
            </div>
          </div>
        </div>
      </div>
    @endif

    <!-- Contact Information Section -->
    <div class="bg-white rounded-lg shadow p-6 space-y-6">
      <div class="flex items-center">
        <x-myds.icon name="user" class="mr-2 text-gray-600" aria-hidden="true" />
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
          Maklumat Perhubungan / Contact Information
        </h2>
      </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Location -->
        <div>
          <x-myds.form-input
            id="location"
            name="location"
            label="Lokasi / Location"
            wire:model="location"
            placeholder="Pejabat, bilik, atau lokasi..."
            maxlength="255"
            error="{{ $errors->first('location') }}"
          />
          <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Nyatakan lokasi di mana masalah berlaku. / Specify the location where the issue occurred.</p>
        </div>

        <!-- Contact Phone -->
        <div>
          <x-myds.form-input
            id="contact_phone"
            name="contact_phone"
            label="No. Telefon Perhubungan / Contact Phone"
            type="tel"
            wire:model="contact_phone"
            placeholder="012-3456789"
            maxlength="20"
            error="{{ $errors->first('contact_phone') }}"
          />
          <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Untuk dihubungi jika diperlukan. / For contact if necessary.</p>
        </div>
      </div>
    </div>

    <!-- Form Actions -->
    <div class="bg-white border border-gray-200 rounded-lg p-6">
      <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div class="flex items-start text-sm text-gray-600 dark:text-gray-400">
          <x-myds.icon name="information-circle" class="mr-2 mt-0.5 flex-shrink-0" aria-hidden="true" />
          <span>
            Tiket akan dihantar kepada pasukan ICT untuk tindakan.
            <br />
            Ticket will be sent to ICT team for action.
          </span>
        </div>

        <div class="flex flex-col sm:flex-row gap-4">
          <x-myds.button
            href="{{ route('helpdesk.index') }}"
            variant="secondary"
            iconLeading="arrow-left"
          >
            Batal / Cancel
          </x-myds.button>

          <x-myds.button
            type="submit"
            variant="primary"
            wire:loading.attr="disabled"
            wire:target="submit"
          >
            <span wire:loading.remove wire:target="submit">
              <x-myds.icon name="paper-airplane" class="mr-2" aria-hidden="true" />
              Hantar Laporan / Submit Report
            </span>
            <span wire:loading wire:target="submit">
              <x-myds.icon name="refresh" class="mr-2 animate-spin" aria-hidden="true" />
              Menghantar... / Submitting...
            </span>
          </x-myds.button>
        </div>
      </div>
    </div>

    @error('submit')
      <div role="alert">
        <x-myds.alert variant="danger" title="Ralat" description="{{ $message }}" />
      </div>
    @enderror
  </form>
</div>
