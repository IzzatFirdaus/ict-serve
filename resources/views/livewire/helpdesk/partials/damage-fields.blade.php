{{--
    ICTServe (iServe) – Damage-Specific Fields (MYDS & MyGovEA Compliant)
    Follows: MYDS tokens, icons, accessibility, and MyGovEA citizen-centric principles
--}}

<section class="myds-panel myds-panel-warning mt-6" aria-labelledby="damage-info-heading">
    <h3 id="damage-info-heading" class="myds-heading-xs font-semibold text-warning-700 flex items-center gap-2 mb-4">
        <svg class="w-5 h-5 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/>
            <path d="M12 8v4m0 4h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
        Maklumat Kerosakan / Damage Information
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Damage Type --}}
        <div class="myds-field">
            <label for="damage_type" class="myds-label myds-required">
                Jenis Kerosakan / Damage Type
            </label>
            <select wire:model.live="damage_type"
                    id="damage_type"
                    class="myds-select @error('damage_type') myds-input-error @enderror"
                    required
                    aria-describedby="damage_type_error"
            >
                <option value="">Sila Pilih / Please Select</option>
                <option value="physical">Fizikal / Physical</option>
                <option value="software">Perisian / Software</option>
                <option value="electrical">Elektrik / Electrical</option>
                <option value="water">Kerosakan Air / Water Damage</option>
                <option value="theft">Kecurian / Theft</option>
                <option value="vandalism">Vandalisme / Vandalism</option>
                <option value="other">Lain-lain / Other</option>
            </select>
            @error('damage_type')
                <div id="damage_type_error" class="myds-field-error" role="alert">{{ $message }}</div>
            @enderror
        </div>

        {{-- Warranty Status --}}
        <div class="myds-field">
            <label for="warranty_status" class="myds-label myds-required">
                Status Waranti / Warranty Status
            </label>
            <select wire:model.live="warranty_status"
                    id="warranty_status"
                    class="myds-select @error('warranty_status') myds-input-error @enderror"
                    required
                    aria-describedby="warranty_status_error"
            >
                <option value="">Sila Pilih / Please Select</option>
                <option value="active">Aktif / Active</option>
                <option value="expired">Tamat Tempoh / Expired</option>
                <option value="unknown">Tidak Pasti / Unknown</option>
                <option value="not_applicable">Tidak Berkaitan / Not Applicable</option>
            </select>
            @error('warranty_status')
                <div id="warranty_status_error" class="myds-field-error" role="alert">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Damage Cause --}}
    <div class="myds-field mt-6">
        <label for="damage_cause" class="myds-label myds-required">
            Punca Kerosakan / Cause of Damage
        </label>
        <textarea wire:model.live="damage_cause"
                  id="damage_cause"
                  rows="3"
                  maxlength="500"
                  class="myds-textarea @error('damage_cause') myds-input-error @enderror"
                  placeholder="Terangkan apa yang menyebabkan kerosakan / Explain what caused the damage"
                  aria-describedby="damage_cause_error damage_cause_count"
                  required></textarea>
        <div class="flex justify-between mt-1">
            @error('damage_cause')
                <div id="damage_cause_error" class="myds-field-error" role="alert">{{ $message }}</div>
            @else
                <span></span>
            @enderror
            <span id="damage_cause_count" class="text-body-xs text-txt-black-500">{{ strlen($damage_cause) }}/500</span>
        </div>
    </div>

    {{-- Damage Extent --}}
    <div class="myds-field mt-6">
        <label for="damage_extent" class="myds-label myds-required">
            Tahap Kerosakan / Extent of Damage
        </label>
        <textarea wire:model.live="damage_extent"
                  id="damage_extent"
                  rows="3"
                  maxlength="500"
                  class="myds-textarea @error('damage_extent') myds-input-error @enderror"
                  placeholder="Huraikan sejauh mana kerosakan yang berlaku / Describe the extent of the damage"
                  aria-describedby="damage_extent_error damage_extent_count"
                  required></textarea>
        <div class="flex justify-between mt-1">
            @error('damage_extent')
                <div id="damage_extent_error" class="myds-field-error" role="alert">{{ $message }}</div>
            @else
                <span></span>
            @enderror
            <span id="damage_extent_count" class="text-body-xs text-txt-black-500">{{ strlen($damage_extent) }}/500</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        {{-- Estimated Cost --}}
        <div class="myds-field">
            <label for="estimated_cost" class="myds-label">
                Anggaran Kos Pembaikan / Estimated Repair Cost <span class="text-txt-black-500">(RM)</span>
            </label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-txt-black-500 text-body-xs">RM</span>
                <input type="number"
                       wire:model.live="estimated_cost"
                       id="estimated_cost"
                       min="0"
                       max="999999.99"
                       step="0.01"
                       class="myds-input pl-10 @error('estimated_cost') myds-input-error @enderror"
                       placeholder="0.00"
                       aria-describedby="estimated_cost_error">
            </div>
            @error('estimated_cost')
                <div id="estimated_cost_error" class="myds-field-error" role="alert">{{ $message }}</div>
            @enderror
        </div>

        {{-- Replacement Needed --}}
        <div class="myds-field">
            <label class="myds-label myds-required">
                Penggantian Diperlukan? / Replacement Needed?
            </label>
            <div class="flex items-center gap-6 mt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio"
                        wire:model.live="replacement_needed"
                        value="1"
                        class="myds-radio @error('replacement_needed') myds-input-error @enderror"
                        aria-describedby="replacement_needed_error">
                    <span class="text-body-sm text-txt-black-900">Ya / Yes</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio"
                        wire:model.live="replacement_needed"
                        value="0"
                        class="myds-radio @error('replacement_needed') myds-input-error @enderror"
                        aria-describedby="replacement_needed_error">
                    <span class="text-body-sm text-txt-black-900">Tidak / No</span>
                </label>
            </div>
            @error('replacement_needed')
                <div id="replacement_needed_error" class="myds-field-error" role="alert">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Visual Damage Indicators for Physical --}}
    @if($damage_type === 'physical')
        <div class="myds-panel myds-panel-info mt-6 bg-warning-50 border-warning-200">
            <h4 class="myds-heading-2xs text-warning-700 flex items-center gap-2 mb-2">
                <svg class="w-4 h-4 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M13 16h-1v-4h-1m1-4h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                Petua untuk Kerosakan Fizikal / Tips for Physical Damage
            </h4>
            <p class="text-body-xs text-warning-700">
                Ambil gambar kerosakan dari pelbagai sudut dan sertakan sebagai lampiran.<br>
                Jangan cuba membaiki sendiri jika melibatkan komponen dalaman.<br>
                <span class="font-medium">Take photos of damage from multiple angles and attach. Do not attempt self-repair if internal components are involved.</span>
            </p>
        </div>
    @endif
</section>
