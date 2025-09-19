{{--
  Partial: Update Password Form
  Updated to use standard HTML with MYDS classes, Bahasa Melayu text,
  and an Alpine.js-powered show/hide toggle for password fields. This aligns with
  MyGovEA principles of Pencegahan Ralat (Error Prevention) and Kawalan Pengguna (User Control).
--}}
<section>
  <header>
    <h2
      class="text-lg font-medium font-poppins text-txt-black-900 dark:text-white"
    >
      Tukar Kata Laluan
    </h2>

    <p class="mt-1 text-sm text-txt-black-600 dark:text-txt-black-400">
      Pastikan akaun anda menggunakan kata laluan yang panjang dan rawak untuk
      kekal selamat.
    </p>
  </header>

  <form
    method="post"
    action="{{ route('password.update') }}"
    class="mt-6 space-y-6"
  >
    @csrf
    @method('put')

    {{-- Current Password --}}
    <div>
      <label
        for="update_password_current_password"
        class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
      >
        Kata Laluan Semasa
      </label>
      <input
        id="update_password_current_password"
        name="current_password"
        type="password"
        autocomplete="current-password"
        class="mt-1 block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary"
      />
      @error('current_password', 'updatePassword')
        <p class="mt-2 text-sm text-txt-danger">{{ $message }}</p>
      @enderror
    </div>

    {{-- New Password with Show/Hide Toggle (MYDS Pattern) --}}
    <div x-data="{ showPassword: false }">
      <label
        for="update_password_password"
        class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
      >
        Kata Laluan Baharu
      </label>
      <div class="relative mt-1">
        <input
          id="update_password_password"
          name="password"
          :type="showPassword ? 'text' : 'password'"
          autocomplete="new-password"
          class="block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary pr-10"
        />
        <button
          type="button"
          @click="showPassword = !showPassword"
          class="absolute inset-y-0 right-0 flex items-center px-3 text-txt-black-500 hover:text-txt-black-700"
          aria-label="Tunjuk/Sembunyi Kata Laluan"
        >
          {{-- The use of icons like 'eye-show' and 'eye-hide' is a standard MYDS pattern --}}
          <x-heroicon-o-eye x-show="!showPassword" class="h-5 w-5" />
          <x-heroicon-o-eye-slash
            x-show="showPassword"
            class="h-5 w-5"
            x-cloak
          />
        </button>
      </div>
      @error('password', 'updatePassword')
        <p class="mt-2 text-sm text-txt-danger">{{ $message }}</p>
      @enderror
    </div>

    {{-- Confirm Password with Show/Hide Toggle --}}
    <div x-data="{ showPassword: false }">
      <label
        for="update_password_password_confirmation"
        class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
      >
        Sahkan Kata Laluan
      </label>
      <div class="relative mt-1">
        <input
          id="update_password_password_confirmation"
          name="password_confirmation"
          :type="showPassword ? 'text' : 'password'"
          autocomplete="new-password"
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
      @error('password_confirmation', 'updatePassword')
        <p class="mt-2 text-sm text-txt-danger">{{ $message }}</p>
      @enderror
    </div>

    {{-- Actions --}}
    <div class="flex items-center gap-4">
      {{-- Buttons are styled according to MYDS specifications for primary actions --}}
      <button
        type="submit"
        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fr-primary"
      >
        Simpan
      </button>

      @if (session('status') === 'password-updated')
        <p
          x-data="{ show: true }"
          x-show="show"
          x-transition
          x-init="setTimeout(() => (show = false), 2000)"
          class="text-sm text-txt-success dark:text-success-400"
        >
          Telah Disimpan.
        </p>
      @endif
    </div>
  </form>
</section>
