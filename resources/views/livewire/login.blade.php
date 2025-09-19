{{--
  ICTServe (iServe) User Login Component
  ======================================
  This component provides a secure and user-friendly login form, styled according to MYDS.
  
  MYDS & MyGovEA Principles Applied:
  - Berpaksikan Rakyat (Citizen-Centric): The form uses clear Bahasa Melayu, includes a "Remember Me" option for convenience, and a "Forgot Password" link for easy recovery.
  - Pencegahan Ralat (Error Prevention): The password field includes a show/hide toggle to help users verify their input and avoid typing errors. The submit button is disabled during login to prevent multiple attempts.
  - Seragam (Consistent): Uses MYDS tokens for all visual elements (colors, spacing, typography, inputs, buttons) to maintain a consistent user interface across the application.
  - Aksesibiliti: All form inputs are properly associated with labels. Interactive elements have clear focus states (focus:ring-fr-primary) for keyboard navigation.
  - Komponen UI/UX: Implements standard login page components, including a link to the registration page for new users.
--}}

<div class="max-w-md mx-auto px-4 py-8 sm:px-6 lg:px-8 font-inter">
  {{-- Card component using MYDS styling --}}
  <div
    class="bg-white dark:bg-gray-900 border border-otl-gray-200 dark:border-otl-gray-800 rounded-lg shadow-card"
  >
    <div class="p-6 border-b border-otl-divider dark:border-otl-divider">
      <h2
        class="text-2xl font-semibold font-poppins text-txt-black-900 dark:text-white text-center"
      >
        Log Masuk ke ICTServe
      </h2>
      <p
        class="mt-2 text-sm text-txt-black-500 dark:text-txt-black-400 text-center"
      >
        Selamat kembali! Sila masukkan butiran anda.
      </p>
    </div>

    <form wire:submit.prevent="login">
      <div class="p-6 space-y-6">
        {{-- Display general login errors --}}
        @error('email')
          <div
            class="p-3 border-l-4 bg-danger-50 dark:bg-danger-950 border-danger-600 dark:border-danger-400"
            role="alert"
          >
            <p class="text-sm text-danger-700 dark:text-danger-300">
              {{ $message }}
            </p>
          </div>
        @enderror

        {{-- Email Input --}}
        <div>
          <label
            for="email"
            class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
          >
            Alamat E-mel
          </label>
          <input
            id="email"
            type="email"
            wire:model.live="email"
            required
            autofocus
            autocomplete="username"
            class="mt-1 block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary"
          />
        </div>

        {{-- Password Input with Show/Hide Toggle --}}
        <div x-data="{ showPassword: false }">
          <label
            for="password"
            class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
          >
            Kata Laluan
          </label>
          <div class="relative mt-1">
            <input
              id="password"
              :type="showPassword ? 'text' : 'password'"
              wire:model.live="password"
              required
              autocomplete="current-password"
              class="block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary pr-10"
            />
            <button
              type="button"
              @click="showPassword = !showPassword"
              class="absolute inset-y-0 right-0 flex items-center px-3 text-txt-black-500 hover:text-txt-black-700"
              aria-label="Tunjuk/Sembunyi Kata Laluan"
            >
              <x-heroicon-o-eye x-show="!showPassword" class="h-5 w-5" />
              <x-heroicon-o-eye-slash
                x-show="showPassword"
                class="h-5 w-5"
                x-cloak
              />
            </button>
          </div>
        </div>

        {{-- Remember Me & Forgot Password --}}
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input
              id="remember"
              wire:model="remember"
              type="checkbox"
              class="h-4 w-4 text-primary-600 border-otl-gray-300 rounded focus:ring-fr-primary"
            />
            <label
              for="remember"
              class="ml-2 block text-sm text-txt-black-700 dark:text-txt-black-300"
            >
              Ingat Saya
            </label>
          </div>

          <div class="text-sm">
            @if (Route::has('password.request'))
              <a
                href="{{ route('password.request') }}"
                class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300"
              >
                Lupa Kata Laluan?
              </a>
            @endif
          </div>
        </div>
      </div>

      <div
        class="flex flex-col items-center justify-between p-6 bg-washed dark:bg-gray-950/50 border-t border-otl-divider dark:border-otl-divider rounded-b-lg"
      >
        <button
          type="submit"
          wire:loading.attr="disabled"
          class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fr-primary disabled:opacity-50 disabled:cursor-not-allowed"
        >
          {{-- Loading spinner, only shows when login action is running --}}
          <svg
            wire:loading
            wire:target="login"
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

          <span wire:loading.remove>Log Masuk</span>
          <span wire:loading>Mengesahkan...</span>
        </button>

        <div class="mt-4 text-sm">
          <span class="text-txt-black-500 dark:text-txt-black-400">
            Tiada akaun?
          </span>
          <a
            href="{{ route('register') }}"
            class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300"
          >
            Daftar di sini
          </a>
        </div>
      </div>
    </form>
  </div>
</div>
