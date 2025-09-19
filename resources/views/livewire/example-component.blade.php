{{--
  ICTServe (iServe) Example Livewire Component
  ============================================
  This component demonstrates a user feedback form that adheres to MYDS and MyGovEA principles.
  
  Key Features Demonstrated:
  - MYDS Components: Styled using MYDS tokens for inputs, buttons, labels, and colors.
  - MYDS Typography: Uses 'Poppins' for headings and 'Inter' for body text.
  - MYDS Spacing: Follows a consistent spacing system for a clean layout.
  - Livewire Integration: Utilizes wire:model.live for real-time validation, wire:submit for actions, and @error for displaying validation messages.
  - Accessibility: Implements <label for="...">, ARIA attributes, and clear focus states (fr-primary).
  - User-Centric Feedback: Provides loading states (wire:loading) and clear success messages (Callout component).
  - Error Prevention: Disables the submit button during processing to prevent duplicate submissions.
--}}

<div class="w-full max-w-3xl mx-auto p-4 sm:p-6 lg:p-8 font-inter">
  {{-- Main container for the form component --}}
  <div
    class="bg-white dark:bg-gray-900 border border-otl-gray-200 dark:border-otl-gray-800 rounded-lg shadow-card"
  >
    <div class="p-6 border-b border-otl-divider dark:border-otl-divider">
      <h2
        class="text-xl font-semibold font-poppins text-txt-black-900 dark:text-txt-white"
      >
        Maklum Balas Pengguna (Contoh Borang MYDS)
      </h2>
      <p class="mt-1 text-sm text-txt-black-500 dark:text-txt-black-400">
        Borang ini menunjukkan implementasi komponen MYDS dengan Livewire.
      </p>
    </div>

    <form wire:submit.prevent="submitFeedback" class="p-6 space-y-6">
      {{-- Success Message: Displayed after a successful submission using a MYDS 'Callout' style --}}
      @if (session()->has('message'))
        <div
          class="p-4 border-l-4 bg-success-50 dark:bg-success-950 border-success-600 dark:border-success-400"
          role="alert"
        >
          <h3 class="font-bold text-success-800 dark:text-success-200">
            Berjaya!
          </h3>
          <p class="text-sm text-success-700 dark:text-success-300">
            {{ session('message') }}
          </p>
        </div>
      @endif

      {{-- Form Field: Name --}}
      <div>
        <label
          for="name"
          class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
        >
          Nama Penuh
        </label>
        <input
          type="text"
          id="name"
          wire:model.live="name"
          class="mt-1 block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary"
          aria-describedby="name-error"
          placeholder="Sila masukkan nama anda"
        />
        @error('name')
          <p id="name-error" class="mt-2 text-sm text-txt-danger">
            {{ $message }}
          </p>
        @enderror
      </div>

      {{-- Form Field: Email --}}
      <div>
        <label
          for="email"
          class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
        >
          Alamat E-mel
        </label>
        <input
          type="email"
          id="email"
          wire:model.live="email"
          class="mt-1 block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary"
          aria-describedby="email-error"
          placeholder="cth: nama@agensi.gov.my"
        />
        @error('email')
          <p id="email-error" class="mt-2 text-sm text-txt-danger">
            {{ $message }}
          </p>
        @enderror
      </div>

      {{-- Form Field: Feedback Type (Select) --}}
      <div>
        <label
          for="feedbackType"
          class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
        >
          Jenis Maklum Balas
        </label>
        <select
          id="feedbackType"
          wire:model.live="feedbackType"
          class="mt-1 block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary"
        >
          <option value="">Sila Pilih Satu</option>
          <option value="cadangan">Cadangan Penambahbaikan</option>
          <option value="laporan_pepijat">Laporan Pepijat (Bug)</option>
          <option value="pertanyaan">Pertanyaan Umum</option>
        </select>
        @error('feedbackType')
          <p class="mt-2 text-sm text-txt-danger">{{ $message }}</p>
        @enderror
      </div>

      {{-- Form Field: Message (Text Area) --}}
      <div>
        <label
          for="message"
          class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
        >
          Mesej Anda
        </label>
        <textarea
          id="message"
          wire:model.live="message"
          rows="4"
          class="mt-1 block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary"
          placeholder="Tuliskan mesej anda di sini..."
        ></textarea>
        @error('message')
          <p class="mt-2 text-sm text-txt-danger">{{ $message }}</p>
        @enderror
      </div>

      {{-- Form Field: Agreement (Checkbox) --}}
      <div class="flex items-start">
        <div class="flex items-center h-5">
          <input
            id="agreement"
            wire:model.live="agreement"
            type="checkbox"
            class="focus:ring-fr-primary h-4 w-4 text-primary-600 border-otl-gray-300 rounded"
          />
        </div>
        <div class="ml-3 text-sm">
          <label
            for="agreement"
            class="font-medium text-txt-black-700 dark:text-txt-black-300"
          >
            Saya Bersetuju
          </label>
          <p class="text-txt-black-500 dark:text-txt-black-400">
            Saya mengesahkan bahawa maklumat yang diberikan adalah benar.
          </p>
          @error('agreement')
            <p class="mt-1 text-sm text-txt-danger">{{ $message }}</p>
          @enderror
        </div>
      </div>

      {{-- Form Actions: Submit Button with Loading State --}}
      <div
        class="flex items-center justify-end pt-4 border-t border-otl-divider dark:border-otl-divider"
      >
        <button
          type="submit"
          wire:loading.attr="disabled"
          wire:target="submitFeedback"
          class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fr-primary disabled:opacity-50 disabled:cursor-not-allowed"
        >
          {{-- Loading spinner, only shows when submitFeedback action is running --}}
          <svg
            wire:loading
            wire:target="submitFeedback"
            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
          >
            <circle
              class="opacity-25"
              cx="12"
              cy="12"
              r="10"
              stroke="currentColor"
              stroke-width="4"
            ></circle>
            <path
              class="opacity-75"
              fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
            ></path>
          </svg>

          <span wire:loading.remove wire:target="submitFeedback">
            Hantar Maklum Balas
          </span>
          <span wire:loading wire:target="submitFeedback">Menghantar...</span>
        </button>
      </div>
    </form>
  </div>
</div>
