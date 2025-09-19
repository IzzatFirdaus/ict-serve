Proposed changes (batch 01) — representative before/after suggestions

This document lists sample replacements to apply for the first batch. The replacements should be applied conservatively; not all occurrences are identical so please review each instance.

1. resources/views/livewire/equipment-loan-form.blade.php
   Before:
   <x-myds.text weight="semibold">Peralatan {{ $index + 1 }}</x-myds.text>
   After:
   <x-myds.text weight="semibold">{{ __('literals.equipment') }} {{ $index + 1 }}</x-myds.text>

Before:
<x-myds.button>Buang</x-myds.button>
After:
<x-myds.button>{{ __('buttons.remove') }}</x-myds.button>

2. resources/views/livewire/damage-complaint-form.blade.php
Before:
  <h3>Maklumat Bantuan</h3>
After:
  <h3>{{ __('help_panel.title') }}</h3>

Replace help panel paragraphs with the keys:
help_panel.processing_time
help_panel.complaint_status
help_panel.emergency_contact

3. resources/views/livewire/loan/create.blade.php
   Before:
   Tambah Peralatan
   After:
   {{ __('buttons.add_equipment') }}

4. resources/views/livewire/equipment-selector.blade.php
   Before:
   Pilih peralatan yang diperlukan untuk permohonan anda.
   After:
   {{ __('forms.help.equipment_selector_instructions') }}

5. resources/views/livewire/helpdesk/create.blade.php
   Before:
   Peralatan Berkaitan / Related Equipment
   After:
   {{ __('forms.labels.related_equipment') }}

...and similarly for the other files listed in i18n-inventory-batch-01.csv

Implementation notes:

- Use atomic JSON updates: write to temp file and rename.
- Preserve interpolation and Blade directives.
- For ambiguous short words, create mapping overrides and request human review.

If you'd like, I can now apply these changes into `staging/feature-i18n-batch-01/preview/` as modified copies for visual review (no commits), or I can attempt direct workspace edits and prepare a patch. Reply with 'preview' to create preview files, or 'apply' to edit the working files directly.
