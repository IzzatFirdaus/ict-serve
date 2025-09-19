{{--
  ICTServe (iServe) Example Counter Component
  ===========================================
  This is a simple, interactive counter component built with Livewire.
  It demonstrates the application of MYDS principles to a basic UI element.
  
  MYDS & MyGovEA Principles Applied:
  - Komponen UI/UX (UI/UX Components): A self-contained, reusable component with clear interactive states.
  - Antara Muka Minimalis dan Mudah (Minimalist and Simple Interface): The design is clean, intuitive, and focuses on the core function.
  - Paparan/Menu Jelas (Clear Display): The count is large and prominent. Buttons use universally understood icons (+/-) for clarity.
  - Seragam (Consistent): Buttons, colors, spacing, and typography all use MYDS tokens.
  - Aksesibiliti: Buttons have `aria-label` attributes for screen readers, and focus states are handled by MYDS classes.
--}}

<div class="w-full max-w-lg mx-auto p-4 sm:p-6 lg:p-8 font-inter">
  {{-- Card component using MYDS styling for a consistent container --}}
  <div
    class="bg-white dark:bg-gray-900 border border-otl-gray-200 dark:border-otl-gray-800 rounded-lg shadow-card"
  >
    <div class="p-6 border-b border-otl-divider dark:border-otl-divider">
      <h2
        class="text-xl font-semibold font-poppins text-txt-black-900 dark:text-white"
      >
        Komponen Kaunter (Counter)
      </h2>
      <p class="mt-1 text-sm text-txt-black-500 dark:text-txt-black-400">
        Klik butang untuk menaikkan atau menurunkan nilai.
      </p>
    </div>

    <div class="p-10 flex items-center justify-center space-x-6">
      {{-- Decrement Button --}}
      <button
        wire:click="decrement"
        type="button"
        class="myds-btn myds-btn-secondary p-3 rounded-full shadow-sm disabled:opacity-50"
        aria-label="Turunkan Nilai"
      >
        <x-heroicon-o-minus class="h-6 w-6" />
      </button>

      {{-- Count Display --}}
      <span
        class="font-poppins text-6xl font-bold text-center w-28 text-txt-black-900 dark:text-white"
        aria-live="polite"
      >
        {{ $count }}
      </span>

      {{-- Increment Button --}}
      <button
        wire:click="increment"
        type="button"
        class="myds-btn myds-btn-primary p-3 rounded-full shadow-sm disabled:opacity-50"
        aria-label="Naikkan Nilai"
      >
        <x-heroicon-o-plus class="h-6 w-6" />
      </button>
    </div>
  </div>
</div>
