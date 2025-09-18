{{--
    ICTServe (iServe) – Incident-Specific Fields
    MYDS & MyGovEA Compliant: Grid, tokens, icons, a11y, citizen-centric, clear hierarchy
--}}

<x-myds.panel variant="danger" class="mt-6" aria-labelledby="incident-info-heading">
    <x-slot name="header">
        <h3 id="incident-info-heading" class="text-heading-xs font-semibold text-danger-700 flex items-center gap-2">
            <x-myds.icon name="exclamation-octagon" class="w-5 h-5 text-danger-600" />
            Maklumat Insiden / Incident Information
        </h3>
    </x-slot>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-myds.field>
            <x-myds.input
                id="incident_datetime"
                name="incident_datetime"
                label="Tarikh & Masa Insiden / Incident Date & Time"
                type="datetime-local"
                wire:model.live="incident_datetime"
                max="{{ now()->format('Y-m-d\TH:i') }}"
                required
                :invalid="$errors->has('incident_datetime')"
            />
            @error('incident_datetime')
                <x-myds.input-error>{{ $message }}</x-myds.input-error>
            @enderror
        </x-myds.field>
        <x-myds.field>
            <x-myds.select
                id="incident_severity"
                name="incident_severity"
                label="Tahap Keterukan / Severity Level"
                wire:model.live="incident_severity"
                required
                :invalid="$errors->has('incident_severity')"
            >
                <option value="">Sila Pilih / Please Select</option>
                <option value="minor">Kecil / Minor</option>
                <option value="moderate">Sederhana / Moderate</option>
                <option value="major">Besar / Major</option>
                <option value="critical">Kritikal / Critical</option>
            </x-myds.select>
            @error('incident_severity')
                <x-myds.input-error>{{ $message }}</x-myds.input-error>
            @enderror
        </x-myds.field>
    </div>
    <x-myds.field class="mt-6">
        <x-myds.textarea
            id="incident_impact"
            name="incident_impact"
            label="Kesan Insiden / Incident Impact"
            wire:model.live="incident_impact"
            rows="3"
            maxlength="500"
            required
            :invalid="$errors->has('incident_impact')"
            hint="Huraikan kesan insiden kepada operasi dan pengguna / Describe the incident impact on operations and users"
        />
        <div class="flex justify-between mt-1">
            @error('incident_impact')
                <x-myds.input-error>{{ $message }}</x-myds.input-error>
            @else
                <span></span>
            @enderror
            <span class="text-body-xs text-txt-black-500">{{ strlen($incident_impact) }}/500</span>
        </div>
    </x-myds.field>
    <x-myds.field class="mt-6">
        <x-myds.textarea
            id="immediate_action_taken"
            name="immediate_action_taken"
            label="Tindakan Segera Diambil / Immediate Action Taken"
            wire:model.live="immediate_action_taken"
            rows="3"
            maxlength="500"
            required
            :invalid="$errors->has('immediate_action_taken')"
            hint="Nyatakan tindakan segera yang telah diambil / State the immediate actions that were taken"
        />
        <div class="flex justify-between mt-1">
            @error('immediate_action_taken')
                <x-myds.input-error>{{ $message }}</x-myds.input-error>
            @else
                <span></span>
            @enderror
            <span class="text-body-xs text-txt-black-500">{{ strlen($immediate_action_taken) }}/500</span>
        </div>
    </x-myds.field>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <x-myds.field>
            <x-myds.textarea
                id="incident_witnesses"
                name="incident_witnesses"
                label="Saksi / Witnesses (Pilihan / Optional)"
                wire:model.live="incident_witnesses"
                rows="2"
                maxlength="500"
                :invalid="$errors->has('incident_witnesses')"
                hint="Nama dan butiran saksi jika ada / Names and details of witnesses if any"
            />
            @error('incident_witnesses')
                <x-myds.input-error>{{ $message }}</x-myds.input-error>
            @enderror
        </x-myds.field>
        <x-myds.field>
            <x-myds.textarea
                id="incident_location_details"
                name="incident_location_details"
                label="Butiran Lokasi / Location Details (Pilihan / Optional)"
                wire:model.live="incident_location_details"
                rows="2"
                maxlength="500"
                :invalid="$errors->has('incident_location_details')"
                hint="Butiran terperinci lokasi insiden / Detailed location of the incident"
            />
            @error('incident_location_details')
                <x-myds.input-error>{{ $message }}</x-myds.input-error>
            @enderror
        </x-myds.field>
    </div>
</x-myds.panel>
