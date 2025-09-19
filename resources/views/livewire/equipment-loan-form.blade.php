<div>
  @section('title', __('forms.titles.equipment_loan_form'))

  <!-- Content Banner -->
  <div class="bg-primary-50 border-b border-otl-divider">
    <x-myds.container>
      <x-myds.grid>
        <x-myds.grid-item span="full">
          <x-myds.heading level="1" class="mb-2">
            {{ __('forms.titles.equipment_loan_form') }}
          </x-myds.heading>
          <x-myds.text variant="secondary" class="mb-3">
            {{ __('forms.subtitles.for_official_use') }}
          </x-myds.text>
          <x-myds.breadcrumb
            :items="[
              ['label' => __('navigation.dashboard'), 'url' => '/'],
              ['label' => __('navigation.servicedesk')],
              ['label' => __('navigation.equipment_loan')]
            ]"
          />
        </x-myds.grid-item>
      </x-myds.grid>
    </x-myds.container>
  </div>

  <x-myds.container class="py-12">
    <x-myds.grid>
      <x-myds.grid-item span="10" offset="1">
        <!-- Success Message -->
        @if (session('success'))
          <x-myds.alert variant="success" class="mb-6">
            <strong>{{ __('alerts.success') }}</strong>
            {{ session('success') }}
          </x-myds.alert>
        @endif

        <form wire:submit="submit" class="space-y-8">
          <!-- Part 1: Applicant Information -->
          <x-myds.card>
            <x-myds.heading
              level="2"
              class="mb-6 pb-3 border-b border-otl-divider"
            >
              {{ __('forms.sections.applicant_info') }}
            </x-myds.heading>

            <x-myds.grid>
              <x-myds.grid-item span="6">
                <x-myds.input
                  label="{{ __('forms.labels.full_name') }}"
                  name="applicant_name"
                  wire:model="applicant_name"
                  required
                  :error="$errors->first('applicant_name')"
                  placeholder="{{ __('forms.placeholders.enter_full_name') }}"
                />
              </x-myds.grid-item>

              <x-myds.grid-item span="6">
                <x-myds.input
                  label="{{ __('forms.labels.position_grade') }}"
                  name="applicant_position"
                  wire:model="applicant_position"
                  required
                  :error="$errors->first('applicant_position')"
                  placeholder="{{ __('forms.placeholders.example_position_local') }}"
                />
              </x-myds.grid-item>

              <x-myds.grid-item span="6">
                <x-myds.select
                  label="{{ __('forms.labels.department') }}"
                  name="applicant_division"
                  wire:model="applicant_division"
                  required
                  :error="$errors->first('applicant_division')"
                  :options="$this->getDivisionOptions()"
                  placeholder="{{ __('forms.placeholders.select_department') }}"
                />
              </x-myds.grid-item>

              <x-myds.grid-item span="6">
                <x-myds.input
                  label="{{ __('forms.labels.phone') }}"
                  name="applicant_phone"
                  wire:model="applicant_phone"
                  required
                  :error="$errors->first('applicant_phone')"
                  placeholder="{{ __('forms.placeholders.enter_phone') }}"
                />
              </x-myds.grid-item>

              <x-myds.grid-item span="full">
                <x-myds.textarea
                  label="{{ __('forms.labels.purpose') }}"
                  name="purpose"
                  wire:model="purpose"
                  required
                  :error="$errors->first('purpose')"
                  placeholder="{{ __('forms.placeholders.enter_purpose') }}"
                  rows="3"
                />
              </x-myds.grid-item>

              <x-myds.grid-item span="6">
                <x-myds.input
                  label="{{ __('forms.labels.location') }}"
                  name="location"
                  wire:model="location"
                  required
                  :error="$errors->first('location')"
                  placeholder="{{ __('forms.placeholders.enter_location') }}"
                />
              </x-myds.grid-item>

              <x-myds.grid-item span="6">
                <x-myds.input
                  label="{{ __('forms.labels.loan_start_date') }}"
                  name="loan_start_date"
                  type="date"
                  wire:model="loan_start_date"
                  required
                  :error="$errors->first('loan_start_date')"
                />
              </x-myds.grid-item>

              <x-myds.grid-item span="6">
                <x-myds.input
                  label="{{ __('forms.labels.loan_end_date') }}"
                  name="loan_end_date"
                  type="date"
                  wire:model="loan_end_date"
                  required
                  :error="$errors->first('loan_end_date')"
                />
              </x-myds.grid-item>
            </x-myds.grid>
          </x-myds.card>

          <!-- Part 2: Responsible Officer Information -->
          <x-myds.card>
            <x-myds.heading
              level="2"
              class="mb-6 pb-3 border-b border-otl-divider"
            >
              {{ __('forms.sections.responsible_officer_info') }}
            </x-myds.heading>

            <div class="mb-6">
              <x-myds.checkbox
                label="{{ __('forms.labels.same_as_applicant') }}"
                name="is_same_person"
                wire:model.live="is_same_person"
              />
            </div>

            @if (! $is_same_person)
              <div class="p-4 bg-gray-50 rounded-[var(--radius-m)]">
                <x-myds.grid>
                  <x-myds.grid-item span="6">
                    <x-myds.input
                      label="{{ __('forms.labels.full_name') }}"
                      name="responsible_name"
                      wire:model="responsible_name"
                      required
                      :error="$errors->first('responsible_name')"
                      placeholder="{{ __('forms.placeholders.enter_full_name') }}"
                    />
                  </x-myds.grid-item>

                  <x-myds.grid-item span="6">
                    <x-myds.input
                      label="{{ __('forms.labels.position_grade') }}"
                      name="responsible_position"
                      wire:model="responsible_position"
                      required
                      :error="$errors->first('responsible_position')"
                      placeholder="{{ __('forms.placeholders.example_position') }}"
                    />
                  </x-myds.grid-item>

                  <x-myds.grid-item span="6">
                    <x-myds.input
                      label="{{ __('forms.labels.phone') }}"
                      name="responsible_phone"
                      wire:model="responsible_phone"
                      required
                      :error="$errors->first('responsible_phone')"
                      placeholder="{{ __('forms.placeholders.enter_phone') }}"
                    />
                  </x-myds.grid-item>
                </x-myds.grid>
              </div>
            @endif
          </x-myds.card>

          <!-- Part 3: Equipment Information -->
          <x-myds.card>
            <x-myds.heading
              level="2"
              class="mb-6 pb-3 border-b border-otl-divider"
            >
              {{ __('forms.sections.equipment_info') }}
            </x-myds.heading>

            <div class="space-y-4">
              @foreach ($equipment_items as $index => $item)
                <div
                  class="p-4 border border-otl-gray-200 rounded-[var(--radius-m)] {{ $index > 0 ? 'bg-gray-50' : '' }}"
                >
                  <div class="flex items-center justify-between mb-4">
                    <x-myds.text weight="semibold">
                        {{ __('literals.equipment') }} {{ $index + 1 }}
                    </x-myds.text>
                    @if ($index > 0)
                      <x-myds.button
                        type="button"
                        variant="danger"
                        size="sm"
                        wire:click="removeEquipmentItem({{ $index }})"
                      >
                        {{ __('buttons.remove') }}
                      </x-myds.button>
                    @endif
                  </div>

                  <x-myds.grid>
                    <x-myds.grid-item span="4">
                      <x-myds.select
                        label="{{ __('forms.labels.equipment_type') }}"
                        name="equipment_items.{{ $index }}.type"
                        wire:model="equipment_items.{{ $index }}.type"
                        required
                        :error="$errors->first('equipment_items.' . $index . '.type')"
                        :options="$this->getEquipmentTypeOptions()"
                        placeholder="{{ __('forms.placeholders.select_equipment_type') }}"
                      />
                    </x-myds.grid-item>

                    <x-myds.grid-item span="4">
                      <x-myds.input
                        label="{{ __('forms.labels.quantity') }}"
                        name="equipment_items.{{ $index }}.quantity"
                        type="number"
                        wire:model="equipment_items.{{ $index }}.quantity"
                        required
                        min="1"
                        max="10"
                        :error="$errors->first('equipment_items.' . $index . '.quantity')"
                      />
                    </x-myds.grid-item>

                    <x-myds.grid-item span="4">
                      <x-myds.input
                        label="{{ __('forms.labels.notes') }}"
                        name="equipment_items.{{ $index }}.notes"
                        wire:model="equipment_items.{{ $index }}.notes"
                        placeholder="{{ __('forms.placeholders.notes_local') }}"
                      />
                    </x-myds.grid-item>
                  </x-myds.grid>
                </div>
              @endforeach

              <div class="flex justify-center">
                <x-myds.button
                  type="button"
                  variant="outline"
                  wire:click="addEquipmentItem"
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
                      d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                    ></path>
                  </svg>
                  {{ __('buttons.add_equipment') }}
                </x-myds.button>
              </div>
            </div>
          </x-myds.card>

          <!-- Action Buttons -->
          <x-myds.card>
            <div class="flex flex-col sm:flex-row gap-4">
              <x-myds.button type="submit" class="flex-1">
                {{ __('buttons.submit_application') }}
              </x-myds.button>

              <x-myds.button
                type="button"
                variant="secondary"
                wire:click="resetForm"
                class="flex-1"
              >
                {{ __('buttons.reset_form') }}
              </x-myds.button>
            </div>
          </x-myds.card>
        </form>

        <!-- Terms and Conditions -->
        <x-myds.alert variant="warning" class="mt-8">
          <x-myds.heading level="4" class="mb-4">
            {{ __('forms.terms.title') }}
          </x-myds.heading>
          <div class="space-y-2">
            <x-myds.text size="sm">
              • {{ __('forms.terms.complete_form') }}
            </x-myds.text>
            <x-myds.text size="sm">
              • {{ __('forms.terms.availability') }}
            </x-myds.text>
            <x-myds.text size="sm">
              • {{ __('forms.terms.processing_time') }}
            </x-myds.text>
            <x-myds.text size="sm">
              • {{ __('forms.terms.applicant_responsibility') }}
            </x-myds.text>
            <x-myds.text size="sm">
              • {{ __('forms.terms.approval_requirement') }}
            </x-myds.text>
          </div>
        </x-myds.alert>
      </x-myds.grid-item>
    </x-myds.grid>
  </x-myds.container>
</div>
