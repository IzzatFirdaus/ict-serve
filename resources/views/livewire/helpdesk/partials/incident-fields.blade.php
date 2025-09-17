{{--
    ICTServe (iServe) – Incident-Specific Fields
    MYDS & MyGovEA Compliant: Grid, tokens, icons, a11y, citizen-centric, clear hierarchy
--}}

<section class="myds-panel myds-panel-danger mt-6" aria-labelledby="incident-info-heading">
    <h3 id="incident-info-heading" class="myds-heading-xs font-semibold text-danger-700 flex items-center gap-2 mb-4">
        <svg class="w-5 h-5 text-danger-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <polygon points="12 2 2 22 22 22 12 2" stroke="currentColor" stroke-width="1.5" fill="none"/>
            <path d="M12 9v4m0 4h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
        Maklumat Insiden / Incident Information
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Incident Date & Time --}}
        <div class="myds-field">
            <label for="incident_datetime" class="myds-label myds-required">
                Tarikh & Masa Insiden / Incident Date & Time
            </label>
            <input type="datetime-local"
                   wire:model.live="incident_datetime"
                   id="incident_datetime"
                   max="{{ now()->format('Y-m-d\TH:i') }}"
                   class="myds-input @error('incident_datetime') myds-input-error @enderror"
                   required
                   aria-describedby="incident_datetime_error">
            @error('incident_datetime')
                <div id="incident_datetime_error" class="myds-field-error" role="alert">{{ $message }}</div>
            @enderror
        </div>

        {{-- Incident Severity --}}
        <div class="myds-field">
            <label for="incident_severity" class="myds-label myds-required">
                Tahap Keterukan / Severity Level
            </label>
            <select wire:model.live="incident_severity"
                    id="incident_severity"
                    class="myds-select @error('incident_severity') myds-input-error @enderror"
                    required
                    aria-describedby="incident_severity_error">
                <option value="">Sila Pilih / Please Select</option>
                <option value="minor">Kecil / Minor</option>
                <option value="moderate">Sederhana / Moderate</option>
                <option value="major">Besar / Major</option>
                <option value="critical">Kritikal / Critical</option>
            </select>
            @error('incident_severity')
                <div id="incident_severity_error" class="myds-field-error" role="alert">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Incident Impact --}}
    <div class="myds-field mt-6">
        <label for="incident_impact" class="myds-label myds-required">
            Kesan Insiden / Incident Impact
        </label>
        <textarea wire:model.live="incident_impact"
                  id="incident_impact"
                  rows="3"
                  maxlength="500"
                  class="myds-textarea @error('incident_impact') myds-input-error @enderror"
                  placeholder="Huraikan kesan insiden kepada operasi dan pengguna / Describe the incident impact on operations and users"
                  required
                  aria-describedby="incident_impact_error incident_impact_count"></textarea>
        <div class="flex justify-between mt-1">
            @error('incident_impact')
                <div id="incident_impact_error" class="myds-field-error" role="alert">{{ $message }}</div>
            @else
                <span></span>
            @enderror
            <span id="incident_impact_count" class="text-body-xs text-txt-black-500">{{ strlen($incident_impact) }}/500</span>
        </div>
    </div>

    {{-- Immediate Action Taken --}}
    <div class="myds-field mt-6">
        <label for="immediate_action_taken" class="myds-label myds-required">
            Tindakan Segera Diambil / Immediate Action Taken
        </label>
        <textarea wire:model.live="immediate_action_taken"
                  id="immediate_action_taken"
                  rows="3"
                  maxlength="500"
                  class="myds-textarea @error('immediate_action_taken') myds-input-error @enderror"
                  placeholder="Nyatakan tindakan segera yang telah diambil / State the immediate actions that were taken"
                  required
                  aria-describedby="immediate_action_taken_error immediate_action_taken_count"></textarea>
        <div class="flex justify-between mt-1">
            @error('immediate_action_taken')
                <div id="immediate_action_taken_error" class="myds-field-error" role="alert">{{ $message }}</div>
            @else
                <span></span>
            @enderror
            <span id="immediate_action_taken_count" class="text-body-xs text-txt-black-500">{{ strlen($immediate_action_taken) }}/500</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        {{-- Witnesses --}}
        <div class="myds-field">
            <label for="incident_witnesses" class="myds-label">
                Saksi / Witnesses <span class="text-txt-black-500">(Pilihan / Optional)</span>
            </label>
            <textarea wire:model.live="incident_witnesses"
                      id="incident_witnesses"
                      rows="2"
                      maxlength="500"
                      class="myds-textarea @error('incident_witnesses') myds-input-error @enderror"
                      placeholder="Nama dan butiran saksi jika ada / Names and details of witnesses if any"
                      aria-describedby="incident_witnesses_error"></textarea>
            @error('incident_witnesses')
                <div id="incident_witnesses_error" class="myds-field-error" role="alert">{{ $message }}</div>
            @enderror
        </div>

        {{-- Location Details --}}
        <div class="myds-field">
            <label for="incident_location_details" class="myds-label">
                Butiran Lokasi / Location Details <span class="text-txt-black-500">(Pilihan / Optional)</span>
            </label>
            <textarea wire:model.live="incident_location_details"
                      id="incident_location_details"
                      rows="2"
                      maxlength="500"
                      class="myds-textarea @error('incident_location_details') myds-input-error @enderror"
                      placeholder="Butiran terperinci lokasi insiden / Detailed location of the incident"
                      aria-describedby="incident_location_details_error"></textarea>
            @error('incident_location_details')
                <div id="incident_location_details_error" class="myds-field-error" role="alert">{{ $message }}</div>
            @enderror
        </div>
    </div>
</section>
