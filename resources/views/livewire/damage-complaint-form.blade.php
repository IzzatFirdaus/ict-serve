<div>
  <!-- Content Banner -->
  <div
    class="bg-primary-50 border-b border-otl-divider relative overflow-hidden"
  >
    <div class="myds-container py-8">
      <div class="myds-grid-12">
        <div class="col-span-full">
          <h1 class="myds-heading-md text-txt-black-900 mb-2">
            {{ __('forms.titles.damage_complaint_form') }}
          </h1>
          <nav class="text-sm text-txt-black-500" aria-label="Breadcrumb">
            <a href="/" class="hover:text-txt-primary">
              {{ __('navigation.dashboard') }}
            </a>
            <span class="mx-2">/</span>
            <span>{{ __('navigation.servicedesk') }}</span>
          </nav>
        </div>
      </div>
    </div>
    <!-- Decorative background with telephone receiver graphic -->
    <div class="absolute inset-0 opacity-5">
      <svg
        class="w-32 h-32 absolute top-4 right-8 transform rotate-12"
        fill="currentColor"
        viewBox="0 0 24 24"
      >
        <path
          d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"
        />
      </svg>
    </div>
  </div>

  <div class="myds-container py-12">
    <div class="myds-grid-12">
      <div class="col-span-full lg:col-span-8 lg:col-start-3">
        <!-- Success Message -->
        @if (session('success'))
          <div
            class="mb-6 p-4 bg-success-50 border border-otl-success-200 rounded-[var(--radius-m)]"
          >
            <div class="flex">
              <svg
                class="w-5 h-5 text-txt-success mt-0.5 mr-3"
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
                <h4 class="text-sm font-semibold text-txt-success mb-1">
                  {{ __('alerts.success') }}
                </h4>
                <p class="text-sm text-txt-success">
                  {{ session('success') }}
                </p>
              </div>
            </div>
          </div>
        @endif

        <!-- Main Form -->
        <div
          class="bg-white rounded-[var(--radius-xl)] border border-otl-gray-200 shadow-md p-8"
        >
          <form wire:submit="submit" class="space-y-6">
            <!-- Full Name -->
            <x-myds.form.input
              label="{{ __('forms.labels.full_name') }}"
              name="full_name"
              wire:model="full_name"
              required
              :error="$errors->first('full_name')"
              placeholder="{{ __('forms.placeholders.enter_full_name') }}"
            />

            <!-- Division -->
            <x-myds.form.select
              label="{{ __('forms.labels.department') }}"
              name="division"
              wire:model="division"
              required
              :error="$errors->first('division')"
              :options="$this->getDivisionOptions()"
              placeholder="{{ __('forms.placeholders.select_department') }}"
            />

            <!-- Position Grade -->
            <x-myds.form.input
              label="{{ __('forms.labels.position_grade') }}"
              name="position_grade"
              wire:model="position_grade"
              :error="$errors->first('position_grade')"
              placeholder="{{ __('forms.placeholders.example_position_grade') }}"
              help="Medan ini adalah pilihan"
            />

            <!-- Email -->
            <x-myds.form.input
              label="{{ __('forms.labels.email') }}"
              name="email"
              type="email"
              wire:model="email"
              required
              :error="$errors->first('email')"
              placeholder="{{ __('forms.placeholders.example_email') }}"
            />

            <!-- Phone Number -->
            <x-myds.form.input
              label="{{ __('forms.labels.phone') }}"
              name="phone_number"
              wire:model="phone_number"
              required
              :error="$errors->first('phone_number')"
              placeholder="{{ __('forms.placeholders.enter_phone') }}"
            />

            <!-- Damage Type -->
            <x-myds.form.select
              label="{{ __('forms.labels.damage_type') }}"
              name="damage_type"
              wire:model.live="damage_type"
              required
              :error="$errors->first('damage_type')"
              :options="$this->getDamageTypeOptions()"
              placeholder="{{ __('forms.placeholders.select_damage_type') }}"
            />

            <!-- Asset Number (Conditional) -->
            @if ($this->show_asset_number)
              <div
                class="p-4 bg-warning-50 border border-otl-warning-200 rounded-[var(--radius-m)]"
              >
                <x-myds.form.input
                  label="{{ __('forms.labels.asset_number') }}"
                  name="asset_number"
                  wire:model="asset_number"
                  required
                  :error="$errors->first('asset_number')"
                  placeholder="{{ __('forms.placeholders.enter_asset_number') }}"
                  help="{{ __('forms.help.asset_number_required') }}"
                />
              </div>
            @endif

            <!-- Damage Information -->
            <x-myds.form.textarea
              label="{{ __('forms.labels.damage_info') }}"
              name="damage_info"
              wire:model="damage_info"
              required
              :error="$errors->first('damage_info')"
              placeholder="{{ __('forms.placeholders.enter_damage_info') }}"
              rows="6"
              help="{{ __('forms.help.provide_details') }}"
            />

            <!-- Declaration -->
            <div
              class="p-6 bg-gray-50 rounded-[var(--radius-m)] border border-otl-gray-200"
            >
              <x-myds.form.checkbox
                label="{{ __('forms.labels.declaration_text') }}"
                name="declaration"
                wire:model.live="declaration"
                required
                :error="$errors->first('declaration')"
              />
            </div>

            <!-- Action Buttons (Only show when declaration is checked) -->
            @if ($declaration)
              <div
                class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-otl-divider"
              >
                <x-myds.button
                  type="submit"
                  class="flex-1"
                  :loading="$this->form->processing ?? false"
                >
                  {{ __('buttons.submit_complaint') }}
                </x-myds.button>

                <x-myds.button
                  type="button"
                  variant="secondary"
                  wire:click="resetForm"
                  class="flex-1"
                >
                  {{ __('buttons.reset') }}
                </x-myds.button>
              </div>
            @endif
          </form>
        </div>

        <!-- Help Information -->
        <div
          class="mt-8 p-6 bg-primary-50 rounded-[var(--radius-m)] border border-otl-primary-200"
        >
          <h3 class="myds-heading-2xs text-txt-primary mb-4">
            {{ __('help_panel.title') }}
          </h3>
          <div class="space-y-3 text-sm text-txt-black-700">
            <p>
              <strong>
                {{ (__('help_panel.processing_time_title', [], null) ?: __('help_panel.processing_time')) ? __('help_panel.processing_time') : __('help_panel.processing_time') }}
              </strong>
            </p>
            <p>{{ __('help_panel.processing_time') }}</p>
            <p>
              <strong>
                {{ (__('help_panel.complaint_status_title', [], null) ?: __('help_panel.complaint_status')) ? __('help_panel.complaint_status') : __('help_panel.complaint_status') }}
              </strong>
            </p>
            <p>{{ __('help_panel.complaint_status') }}</p>
            <p>
              <strong>
                {{ (__('help_panel.emergency_contact_title', [], null) ?: __('help_panel.emergency_contact')) ? __('help_panel.emergency_contact') : __('help_panel.emergency_contact') }}
              </strong>
            </p>
            <p>{{ __('help_panel.emergency_contact') }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
