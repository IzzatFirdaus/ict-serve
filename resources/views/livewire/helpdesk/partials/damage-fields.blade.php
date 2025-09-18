{{--
    ICTServe (iServe) – Damage-Specific Fields (MYDS & MyGovEA Compliant)
    Follows: MYDS tokens, icons, accessibility, and MyGovEA citizen-centric principles
--}}

<x-myds.panel variant="warning" class="mt-6" aria-labelledby="damage-info-heading">
    <x-slot name="header">
        <h3 id="damage-info-heading" class="text-heading-xs font-semibold text-warning-700 flex items-center gap-2">
            <x-myds.icon name="exclamation-triangle" class="w-5 h-5 text-warning-600" />
            Maklumat Kerosakan / Damage Information
        </h3>
    </x-slot>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Damage Type --}}
        <x-myds.field>
            <x-myds.select
                id="damage_type"
                name="damage_type"
                label="Jenis Kerosakan / Damage Type"
                wire:model.live="damage_type"
                required
                :invalid="$errors->has('damage_type')"
            >
                <option value="">Sila Pilih / Please Select</option>
                <option value="physical">Fizikal / Physical</option>
                <option value="software">Perisian / Software</option>
                <option value="electrical">Elektrik / Electrical</option>
                <option value="water">Kerosakan Air / Water Damage</option>
                <option value="theft">Kecurian / Theft</option>
                <option value="vandalism">Vandalisme / Vandalism</option>
                <option value="other">Lain-lain / Other</option>
            </x-myds.select>
            @error('damage_type')
                <x-myds.input-error>{{ $message }}</x-myds.input-error>
            @enderror
        </x-myds.field>
        {{-- Warranty Status --}}
        <x-myds.field>
            <x-myds.select
                id="warranty_status"
                name="warranty_status"
                label="Status Waranti / Warranty Status"
                wire:model.live="warranty_status"
                required
                :invalid="$errors->has('warranty_status')"
            >
                <option value="">Sila Pilih / Please Select</option>
                <option value="active">Aktif / Active</option>
                <option value="expired">Tamat Tempoh / Expired</option>
                <option value="unknown">Tidak Pasti / Unknown</option>
                <option value="not_applicable">Tidak Berkaitan / Not Applicable</option>
            </x-myds.select>
            @error('warranty_status')
                <x-myds.input-error>{{ $message }}</x-myds.input-error>
            @enderror
        </x-myds.field>
    </div>
    <x-myds.field class="mt-6">
        <x-myds.textarea
            id="damage_cause"
            name="damage_cause"
            label="Punca Kerosakan / Cause of Damage"
            wire:model.live="damage_cause"
            rows="3"
            maxlength="500"
            required
            :invalid="$errors->has('damage_cause')"
            hint="Terangkan apa yang menyebabkan kerosakan / Explain what caused the damage"
        />
        <div class="flex justify-between mt-1">
            @error('damage_cause')
                <x-myds.input-error>{{ $message }}</x-myds.input-error>
            @else
                <span></span>
            @enderror
            <span class="text-body-xs text-txt-black-500">{{ strlen($damage_cause) }}/500</span>
        </div>
    </x-myds.field>
    <x-myds.field class="mt-6">
        <x-myds.textarea
            id="damage_extent"
            name="damage_extent"
            label="Tahap Kerosakan / Extent of Damage"
            wire:model.live="damage_extent"
            rows="3"
            maxlength="500"
            required
            :invalid="$errors->has('damage_extent')"
            hint="Huraikan sejauh mana kerosakan yang berlaku / Describe the extent of the damage"
        />
        <div class="flex justify-between mt-1">
            @error('damage_extent')
                <x-myds.input-error>{{ $message }}</x-myds.input-error>
            @else
                <span></span>
            @enderror
            <span class="text-body-xs text-txt-black-500">{{ strlen($damage_extent) }}/500</span>
        </div>
    </x-myds.field>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <x-myds.field>
            <x-myds.input
                id="estimated_cost"
                name="estimated_cost"
                label="Anggaran Kos Pembaikan / Estimated Repair Cost (RM)"
                type="number"
                wire:model.live="estimated_cost"
                min="0"
                max="999999.99"
                step="0.01"
                :invalid="$errors->has('estimated_cost')"
                placeholder="0.00"
            >
                <x-slot name="addon">RM</x-slot>
            </x-myds.input>
            @error('estimated_cost')
                <x-myds.input-error>{{ $message }}</x-myds.input-error>
            @enderror
        </x-myds.field>
        <x-myds.field>
            <x-myds.label label="Penggantian Diperlukan? / Replacement Needed?" required />
            <div class="flex items-center gap-6 mt-2">
                <x-myds.radio
                    id="replacement_needed_yes"
                    name="replacement_needed"
                    wire:model.live="replacement_needed"
                    value="1"
                    :checked="$replacement_needed === '1'"
                    label="Ya / Yes"
                />
                <x-myds.radio
                    id="replacement_needed_no"
                    name="replacement_needed"
                    wire:model.live="replacement_needed"
                    value="0"
                    :checked="$replacement_needed === '0'"
                    label="Tidak / No"
                />
            </div>
            @error('replacement_needed')
                <x-myds.input-error>{{ $message }}</x-myds.input-error>
            @enderror
        </x-myds.field>
    </div>
    @if($damage_type === 'physical')
        <x-myds.panel variant="info" class="mt-6 bg-warning-50 border-warning-200">
            <x-slot name="header">
                <h4 class="myds-heading-2xs text-warning-700 flex items-center gap-2 mb-2">
                    <x-myds.icon name="light-bulb" class="w-4 h-4 text-warning-600" />
                    Petua untuk Kerosakan Fizikal / Tips for Physical Damage
                </h4>
            </x-slot>
            <p class="text-body-xs text-warning-700">
                Ambil gambar kerosakan dari pelbagai sudut dan sertakan sebagai lampiran.<br>
                Jangan cuba membaiki sendiri jika melibatkan komponen dalaman.<br>
                <span class="font-medium">Take photos of damage from multiple angles and attach. Do not attempt self-repair if internal components are involved.</span>
            </p>
        </x-myds.panel>
    @endif
</x-myds.panel>
