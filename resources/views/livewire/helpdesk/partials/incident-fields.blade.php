<!-- Incident-Specific Fields -->
<div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6 mt-6">
    <h3 class="text-lg font-semibold text-red-900 dark:text-red-100 mb-4 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.882 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
        </svg>
        Maklumat Insiden / Incident Information
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Incident Date & Time -->
        <div>
            <label for="incident_datetime" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Tarikh & Masa Insiden / Incident Date & Time <span class="text-red-500">*</span>
            </label>
            <input type="datetime-local"
                   wire:model.live="incident_datetime"
                   id="incident_datetime"
                   max="{{ now()->format('Y-m-d\TH:i') }}"
                   class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white">
            @error('incident_datetime')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Incident Severity -->
        <div>
            <label for="incident_severity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Tahap Keterukan / Severity Level <span class="text-red-500">*</span>
            </label>
            <select wire:model.live="incident_severity"
                    id="incident_severity"
                    class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white">
                <option value="minor">Kecil / Minor</option>
                <option value="moderate">Sederhana / Moderate</option>
                <option value="major">Besar / Major</option>
                <option value="critical">Kritikal / Critical</option>
            </select>
            @error('incident_severity')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Incident Impact -->
    <div class="mt-6">
        <label for="incident_impact" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Kesan Insiden / Incident Impact <span class="text-red-500">*</span>
        </label>
        <textarea wire:model.live="incident_impact"
                  id="incident_impact"
                  rows="3"
                  maxlength="500"
                  class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                  placeholder="Huraikan kesan insiden kepada operasi dan pengguna / Describe the incident impact on operations and users"></textarea>
        <div class="flex justify-between mt-1">
            @error('incident_impact')
                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @else
                <span></span>
            @enderror
            <span class="text-xs text-gray-500">{{ strlen($incident_impact) }}/500</span>
        </div>
    </div>

    <!-- Immediate Action Taken -->
    <div class="mt-6">
        <label for="immediate_action_taken" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Tindakan Segera Diambil / Immediate Action Taken <span class="text-red-500">*</span>
        </label>
        <textarea wire:model.live="immediate_action_taken"
                  id="immediate_action_taken"
                  rows="3"
                  maxlength="500"
                  class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                  placeholder="Nyatakan tindakan segera yang telah diambil / State the immediate actions that were taken"></textarea>
        <div class="flex justify-between mt-1">
            @error('immediate_action_taken')
                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @else
                <span></span>
            @enderror
            <span class="text-xs text-gray-500">{{ strlen($immediate_action_taken) }}/500</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <!-- Witnesses -->
        <div>
            <label for="incident_witnesses" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Saksi / Witnesses <span class="text-gray-500">(Pilihan / Optional)</span>
            </label>
            <textarea wire:model.live="incident_witnesses"
                      id="incident_witnesses"
                      rows="2"
                      maxlength="500"
                      class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                      placeholder="Nama dan butiran saksi jika ada / Names and details of witnesses if any"></textarea>
            @error('incident_witnesses')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Location Details -->
        <div>
            <label for="incident_location_details" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Butiran Lokasi / Location Details <span class="text-gray-500">(Pilihan / Optional)</span>
            </label>
            <textarea wire:model.live="incident_location_details"
                      id="incident_location_details"
                      rows="2"
                      maxlength="500"
                      class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                      placeholder="Butiran terperinci lokasi insiden / Detailed location of the incident"></textarea>
            @error('incident_location_details')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
