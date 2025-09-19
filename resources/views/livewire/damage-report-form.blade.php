<div class="myds-container myds-py-6">
  <!-- Page Header -->
  <div class="mb-6">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="Breadcrumb" class="mb-4">
      <ol class="myds-breadcrumb">
        <li class="myds-breadcrumb-item">
          <a href="{{ route('dashboard') }}" class="myds-link">
            {{ __('navigation.dashboard') }}
          </a>
        </li>
        <li class="myds-breadcrumb-item">
          <a href="{{ route('helpdesk.index') }}" class="myds-link">
            {{ __('navigation.helpdesk') }}
          </a>
        </li>
        <li
          class="myds-breadcrumb-item myds-breadcrumb-current"
          aria-current="page"
        >
          {{ __('damage_report.title') }}
        </li>
      </ol>
    </nav>

    <!-- Page Title -->
    <div class="myds-page-header">
      <h1 class="myds-heading-xl text-myds-gray-900 dark:text-myds-gray-100">
        <i class="myds-icon-exclamation-triangle mr-3" aria-hidden="true"></i>
        {{ __('damage_report.title') }}
      </h1>
      <p
        class="myds-text-body-lg text-myds-gray-600 dark:text-myds-gray-400 mt-2"
      >
        {{ __('damage_report.subtitle') }}
      </p>
    </div>
  </div>

  <form wire:submit.prevent="submit" class="myds-space-y-8">
    @csrf

    <!-- Damage Details Section -->
    <div class="myds-card myds-card-elevated">
      <div class="myds-card-header">
        <h2 class="myds-heading-lg text-myds-gray-900 dark:text-myds-gray-100">
          <i class="myds-icon-clipboard-list mr-2" aria-hidden="true"></i>
          {{ __('damage_report.section.damage_details') }}
        </h2>
      </div>

      <div class="myds-card-body">
        <div class="myds-form-grid">
          <!-- Damage Type Dropdown (Dynamic) -->
          <div class="myds-col-span-full">
            <label for="damage_type_id" class="myds-label myds-required">
              {{ __('forms.labels.damage_type') }}
            </label>
            <select
              id="damage_type_id"
              wire:model.live="damage_type_id"
              class="myds-select @error('damage_type_id') myds-input-error @enderror"
              required
              aria-describedby="damage-type-help @error('damage_type_id') damage-type-error @enderror"
            >
              <option value="">
                {{ __('forms.placeholders.select_damage_type') }}
              </option>
              @foreach ($damageTypes as $damageType)
                <option value="{{ $damageType['id'] }}">
                  @if ($damageType['icon'])
                    <i
                      class="{{ $damageType['icon'] }}"
                      aria-hidden="true"
                    ></i>
                  @endif

                  {{ $damageType['display_name'] }}
                  @if ($damageType['display_description'])
                      -
                      {{ Str::limit($damageType['display_description'], 50) }}
                  @endif
                </option>
              @endforeach
            </select>
            <p id="damage-type-help" class="myds-help-text">
              {{ __('damage_report.help.select_type') }}
            </p>
            @error('damage_type_id')
              <p id="damage-type-error" class="myds-error-text" role="alert">
                {{ $message }}
              </p>
            @enderror

            <!-- Show selected damage type details -->
            @if ($damage_type_id)
              @php
                $selectedType = collect($damageTypes)->firstWhere('id', $damage_type_id);
              @endphp

              @if ($selectedType && $selectedType['display_description'])
                <div class="myds-callout myds-callout-info mt-3">
                  <div class="myds-callout-header">
                    <i
                      class="myds-icon-information-circle"
                      aria-hidden="true"
                    ></i>
                    <span>
                      {{ __('damage_report.info.type_information') }}
                    </span>
                  </div>
                  <div class="myds-callout-body">
                    {{ $selectedType['display_description'] }}
                  </div>
                </div>
              @endif
            @endif
          </div>

          <!-- Issue Title -->
          <div class="myds-col-span-full">
            <label for="title" class="myds-label myds-required">
              {{ __('damage_report.labels.title') }}
            </label>
            <input
              type="text"
              id="title"
              wire:model="title"
              class="myds-input @error('title') myds-input-error @enderror"
              placeholder="{{ __('damage_report.placeholders.example_title') }}"
              maxlength="255"
              required
              aria-describedby="title-help @error('title') title-error @enderror"
            />
            <p id="title-help" class="myds-help-text">
              {{ __('damage_report.help.title') }}
            </p>
            @error('title')
              <p id="title-error" class="myds-error-text" role="alert">
                {{ $message }}
              </p>
            @enderror
          </div>

          <!-- Priority Level (Auto-set by damage type) -->
          <div>
            <label for="priority" class="myds-label myds-required">
              {{ __('damage_report.labels.priority') }}
            </label>
            <select
              id="priority"
              wire:model="priority"
              class="myds-select @error('priority') myds-input-error @enderror"
              required
              aria-describedby="priority-help @error('priority') priority-error @enderror"
            >
              <option value="low">
                {{ __('damage_report.priority.low') }}
              </option>
              <option value="medium">
                {{ __('damage_report.priority.medium') }}
              </option>
              <option value="high">
                {{ __('damage_report.priority.high') }}
              </option>
              <option value="critical">
                {{ __('damage_report.priority.critical') }}
              </option>
            </select>
            <p id="priority-help" class="myds-help-text">
              {{ __('damage_report.help.priority_auto') }}
            </p>
            @error('priority')
              <p id="priority-error" class="myds-error-text" role="alert">
                {{ $message }}
              </p>
            @enderror
          </div>

          <!-- Issue Description -->
          <div class="myds-col-span-full">
            <label for="description" class="myds-label myds-required">
              {{ __('damage_report.labels.description') }}
            </label>
            <textarea
              id="description"
              wire:model="description"
              class="myds-textarea @error('description') myds-input-error @enderror"
              rows="5"
              placeholder="{{ __('damage_report.placeholders.description') }}"
              maxlength="2000"
              required
              aria-describedby="description-help @error('description') description-error @enderror"
            ></textarea>
            <p id="description-help" class="myds-help-text">
              {{ __('damage_report.help.description') }}
            </p>
            @error('description')
              <p id="description-error" class="myds-error-text" role="alert">
                {{ $message }}
              </p>
            @enderror
          </div>
        </div>
      </div>
    </div>

    <!-- Equipment Information Section (conditional) -->
    @if ($showEquipmentSelector)
      <div class="myds-card myds-card-elevated">
        <div class="myds-card-header">
          <h2
            class="myds-heading-lg text-myds-gray-900 dark:text-myds-gray-100"
          >
            <i class="myds-icon-desktop-computer mr-2" aria-hidden="true"></i>
            Maklumat Peralatan / Equipment Information
          </h2>
        </div>

        <div class="myds-card-body">
          <div class="myds-form-grid">
            <!-- Equipment Selection -->
            <div class="myds-col-span-full">
              <label for="equipment_item_id" class="myds-label">
                {{ __('damage_report.labels.related_equipment') }}
              </label>
              <select
                id="equipment_item_id"
                wire:model="equipment_item_id"
                class="myds-select @error('equipment_item_id') myds-input-error @enderror"
                aria-describedby="equipment-help @error('equipment_item_id') equipment-error @enderror"
              >
                <option value="">
                  {{ __('forms.placeholders.select_equipment') }}
                </option>
                @foreach ($equipmentItems as $item)
                  <option value="{{ $item['id'] }}">
                    {{ $item['brand'] }} {{ $item['model'] }}
                    @if (! empty($item['serial_number']))
                        (S/N: {{ $item['serial_number'] }})
                    @endif

                    @if (! empty($item['location']))
                        - {{ $item['location'] }}
                    @endif
                  </option>
                @endforeach
              </select>
              <p id="equipment-help" class="myds-help-text">
                {{ __('damage_report.help.select_equipment') }}
              </p>
              @error('equipment_item_id')
                <p id="equipment-error" class="myds-error-text" role="alert">
                  {{ $message }}
                </p>
              @enderror
            </div>
          </div>
        </div>
      </div>
    @endif

    <!-- Contact Information Section -->
    <div class="myds-card myds-card-elevated">
      <div class="myds-card-header">
        <h2 class="myds-heading-lg text-myds-gray-900 dark:text-myds-gray-100">
          <i class="myds-icon-user mr-2" aria-hidden="true"></i>
          {{ __('damage_report.section.contact_information') }}
        </h2>
      </div>

      <div class="myds-card-body">
        <div class="myds-form-grid">
          <!-- Location -->
          <div>
            <label for="location" class="myds-label">Lokasi / Location</label>
            <input
              type="text"
              id="location"
              wire:model="location"
              class="myds-input @error('location') myds-input-error @enderror"
              placeholder="{{ __('forms.placeholders.enter_location') }}"
              maxlength="255"
              aria-describedby="location-help @error('location') location-error @enderror"
            />
            <p id="location-help" class="myds-help-text">
              {{ __('damage_report.help.location') }}
            </p>
            @error('location')
              <p id="location-error" class="myds-error-text" role="alert">
                {{ $message }}
              </p>
            @enderror
          </div>

          <!-- Contact Phone -->
          <div>
            <label for="contact_phone" class="myds-label">
              {{ __('damage_report.labels.contact_phone') }}
            </label>
            <input
              type="tel"
              id="contact_phone"
              wire:model="contact_phone"
              class="myds-input @error('contact_phone') myds-input-error @enderror"
              placeholder="012-3456789"
              maxlength="20"
              aria-describedby="phone-help @error('contact_phone') phone-error @enderror"
            />
            <p id="phone-help" class="myds-help-text">
              {{ __('damage_report.help.contact_phone') }}
            </p>
            @error('contact_phone')
              <p id="phone-error" class="myds-error-text" role="alert">
                {{ $message }}
              </p>
            @enderror
          </div>
        </div>
      </div>
    </div>

    <!-- Form Actions -->
    <div class="myds-card myds-card-bordered">
      <div class="myds-card-body">
        <div class="myds-flex myds-justify-between myds-items-center">
          <div
            class="myds-text-body-sm text-myds-gray-600 dark:text-myds-gray-400"
          >
            <i class="myds-icon-information-circle mr-1" aria-hidden="true"></i>
            <span>
              {{ __('damage_report.notice.sent_to_team') }}
            </span>
          </div>

          <div class="myds-flex myds-space-x-4">
            <a
              href="{{ route('helpdesk.index') }}"
              class="myds-button myds-button-secondary"
            >
              <i class="myds-icon-arrow-left mr-2" aria-hidden="true"></i>
              {{ __('buttons.cancel') }}
            </a>

            <button
              type="submit"
              class="myds-button myds-button-primary"
              wire:loading.attr="disabled"
              wire:target="submit"
            >
              <span wire:loading.remove wire:target="submit">
                <i
                  class="myds-icon-exclamation-triangle mr-2"
                  aria-hidden="true"
                ></i>
                {{ __('buttons.submit_complaint') }}
              </span>
              <span wire:loading wire:target="submit">
                <i
                  class="myds-icon-refresh myds-animate-spin mr-2"
                  aria-hidden="true"
                ></i>
                {{ __('buttons.sending') }}
              </span>
            </button>
          </div>
        </div>
      </div>
    </div>

    @error('submit')
      <div class="myds-alert myds-alert-error" role="alert">
        <i class="myds-icon-exclamation-circle" aria-hidden="true"></i>
        <span>{{ $message }}</span>
      </div>
    @enderror
  </form>

  <!-- Empty State for Damage Types -->
  @if (empty($damageTypes))
    <div class="myds-card myds-card-bordered">
      <div class="myds-card-body text-center py-12">
        <i
          class="myds-icon-exclamation-triangle myds-text-gray-400 text-6xl mb-4"
          aria-hidden="true"
        ></i>
        <h3
          class="myds-heading-md text-myds-gray-700 dark:text-myds-gray-300 mb-2"
        >
          Tiada Jenis Kerosakan Tersedia / No Damage Types Available
        </h3>
        <p class="myds-text-body-md text-myds-gray-600 dark:text-myds-gray-400">
          Sila hubungi pentadbir sistem untuk menambah jenis kerosakan.
          <br />
          Please contact system administrator to add damage types.
        </p>
      </div>
    </div>
  @endif
</div>
