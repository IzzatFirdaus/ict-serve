<!-- Damage-Specific Fields -->
<div
  class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-lg p-6 mt-6"
>
  <h3
    class="text-lg font-semibold text-orange-900 dark:text-orange-100 mb-4 flex items-center"
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
        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
      ></path>
    </svg>
    Maklumat Kerosakan / Damage Information
  </h3>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Damage Type -->
    <div>
      <label
        for="damage_type"
        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
      >
        Jenis Kerosakan / Damage Type
        <span class="text-red-500">*</span>
      </label>
      <select
        wire:model.live="damage_type"
        id="damage_type"
        class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
      >
        <option value="physical">Fizikal / Physical</option>
        <option value="software">Perisian / Software</option>
        <option value="electrical">Elektrik / Electrical</option>
        <option value="water">Kerosakan Air / Water Damage</option>
        <option value="theft">Kecurian / Theft</option>
        <option value="vandalism">Vandalisme / Vandalism</option>
        <option value="other">Lain-lain / Other</option>
      </select>
      @error('damage_type')
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">
          {{ $message }}
        </p>
      @enderror
    </div>

    <!-- Warranty Status -->
    <div>
      <label
        for="warranty_status"
        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
      >
        Status Waranti / Warranty Status
        <span class="text-red-500">*</span>
      </label>
      <select
        wire:model.live="warranty_status"
        id="warranty_status"
        class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
      >
        <option value="active">Aktif / Active</option>
        <option value="expired">Tamat Tempoh / Expired</option>
        <option value="unknown">Tidak Pasti / Unknown</option>
        <option value="not_applicable">Tidak Berkaitan / Not Applicable</option>
      </select>
      @error('warranty_status')
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">
          {{ $message }}
        </p>
      @enderror
    </div>
  </div>

  <!-- Damage Cause -->
  <div class="mt-6">
    <label
      for="damage_cause"
      class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
    >
      Punca Kerosakan / Cause of Damage
      <span class="text-red-500">*</span>
    </label>
    <textarea
      wire:model.live="damage_cause"
      id="damage_cause"
      rows="3"
      maxlength="500"
      class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
      placeholder="Terangkan apa yang menyebabkan kerosakan / Explain what caused the damage"
    ></textarea>
    <div class="flex justify-between mt-1">
      @error('damage_cause')
        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
      @else
        <span></span>
      @enderror
      <span class="text-xs text-gray-500">
        {{ strlen($damage_cause) }}/500
      </span>
    </div>
  </div>

  <!-- Damage Extent -->
  <div class="mt-6">
    <label
      for="damage_extent"
      class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
    >
      Tahap Kerosakan / Extent of Damage
      <span class="text-red-500">*</span>
    </label>
    <textarea
      wire:model.live="damage_extent"
      id="damage_extent"
      rows="3"
      maxlength="500"
      class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
      placeholder="Huraikan sejauh mana kerosakan yang berlaku / Describe the extent of the damage"
    ></textarea>
    <div class="flex justify-between mt-1">
      @error('damage_extent')
        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
      @else
        <span></span>
      @enderror
      <span class="text-xs text-gray-500">
        {{ strlen($damage_extent) }}/500
      </span>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <!-- Estimated Cost -->
    <div>
      <label
        for="estimated_cost"
        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
      >
        Anggaran Kos Pembaikan / Estimated Repair Cost
        <span class="text-gray-500">(RM)</span>
      </label>
      <div class="relative">
        <span
          class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm"
        >
          RM
        </span>
        <input
          type="number"
          wire:model.live="estimated_cost"
          id="estimated_cost"
          min="0"
          max="999999.99"
          step="0.01"
          class="block w-full pl-12 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
          placeholder="0.00"
        />
      </div>
      @error('estimated_cost')
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">
          {{ $message }}
        </p>
      @enderror
    </div>

    <!-- Replacement Needed -->
    <div>
      <label
        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
      >
        Penggantian Diperlukan? / Replacement Needed?
        <span class="text-red-500">*</span>
      </label>
      <div class="flex items-center space-x-6 mt-3">
        <label class="flex items-center cursor-pointer">
          <input
            type="radio"
            wire:model.live="replacement_needed"
            value="1"
            class="w-4 h-4 text-orange-600 border-gray-300 focus:ring-orange-500 focus:ring-2 dark:border-gray-600 dark:bg-gray-700"
          />
          <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
            Ya / Yes
          </span>
        </label>
        <label class="flex items-center cursor-pointer">
          <input
            type="radio"
            wire:model.live="replacement_needed"
            value="0"
            class="w-4 h-4 text-orange-600 border-gray-300 focus:ring-orange-500 focus:ring-2 dark:border-gray-600 dark:bg-gray-700"
          />
          <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
            Tidak / No
          </span>
        </label>
      </div>
      @error('replacement_needed')
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">
          {{ $message }}
        </p>
      @enderror
    </div>
  </div>

  <!-- Visual Damage Indicators -->
  @if ($damage_type === 'physical')
    <div
      class="mt-6 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg"
    >
      <h4
        class="text-sm font-medium text-yellow-800 dark:text-yellow-200 mb-2 flex items-center"
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
            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
          ></path>
        </svg>
        Petua untuk Kerosakan Fizikal / Tips for Physical Damage
      </h4>
      <p class="text-sm text-yellow-700 dark:text-yellow-300">
        Ambil gambar kerosakan dari pelbagai sudut dan sertakan sebagai
        lampiran. Jangan cuba membaiki sendiri jika melibatkan komponen dalaman.
        / Take photos of the damage from multiple angles and attach them. Do not
        attempt self-repair if internal components are involved.
      </p>
    </div>
  @endif
</div>
