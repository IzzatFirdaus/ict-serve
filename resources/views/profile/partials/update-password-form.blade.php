{{--
  Partial: Update Password Form
  Updated to use standard HTML with MYDS classes, Bahasa Melayu text,
  and an Alpine.js-powered show/hide toggle for password fields. This aligns with
  MyGovEA principles of Pencegahan Ralat (Error Prevention) and Kawalan Pengguna (User Control).
--}}
<section>
  <header>
    <h2
      id="update-password-heading"
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
    role="form"
    aria-labelledby="update-password-heading"
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
      <x-myds.input
        id="update_password_current_password"
        name="current_password"
        type="password"
        autocomplete="current-password"
        class="mt-1"
      />
      @error('current_password', 'updatePassword')
        <p class="mt-2 text-xs text-danger-600" role="alert">{{ $message }}</p>
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
        <x-myds.input
          id="update_password_password"
          name="password"
          :type="showPassword ? 'text' : 'password'"
          autocomplete="new-password"
          class="pr-10"
        />
        <x-myds.button
          type="button"
          class="absolute inset-y-0 right-0 flex items-center px-3"
          x-on:click="showPassword = !showPassword"
          aria-label="Tunjuk/Sembunyi Kata Laluan"
          variant="secondary"
          size="sm"
        >
          <x-myds.icon name="eye" size="16" x-show="!showPassword" aria-hidden="true" class="h-4 w-4" />
          <x-myds.icon name="eye-off" size="16" x-show="showPassword" aria-hidden="true" class="h-4 w-4" x-cloak />
        </x-myds.button>
      </div>
      @error('password', 'updatePassword')
        <p class="mt-2 text-xs text-danger-600" role="alert">{{ $message }}</p>
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
        <x-myds.input
          id="update_password_password_confirmation"
          name="password_confirmation"
          :type="showPassword ? 'text' : 'password'"
          autocomplete="new-password"
          class="pr-10"
        />
        <x-myds.button
          type="button"
          class="absolute inset-y-0 right-0 flex items-center px-3"
          x-on:click="showPassword = !showPassword"
          aria-label="Tunjuk/Sembunyi Kata Laluan"
          variant="secondary"
          size="sm"
        >
          <x-myds.icon name="eye" size="16" x-show="!showPassword" aria-hidden="true" class="h-4 w-4" />
          <x-myds.icon name="eye-off" size="16" x-show="showPassword" aria-hidden="true" class="h-4 w-4" x-cloak />
        </x-myds.button>
      </div>
      @error('password_confirmation', 'updatePassword')
        <p class="mt-2 text-xs text-danger-600" role="alert">{{ $message }}</p>
      @enderror
    </div>

    {{-- Actions --}}
    <div class="flex items-center gap-4">
      <x-myds.button type="submit" variant="primary" size="md">Simpan</x-myds.button>

      @if (session('status') === 'password-updated')
        <p
          x-data="{ show: true }"
          x-show="show"
          x-transition
          x-init="setTimeout(() => (show = false), 2000)"
          class="text-sm text-success-600"
        >
          Telah Disimpan.
        </p>
      @endif
    </div>
  </form>
</section>
