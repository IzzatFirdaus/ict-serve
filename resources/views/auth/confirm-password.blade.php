<x-guest-layout>
  <form
    method="POST"
    action="{{ route('password.confirm') }}"
    class="space-y-6"
    role="form"
    aria-labelledby="confirm-heading"
  >
    @csrf

    <h1
      id="confirm-heading"
      class="myds-heading-md text-txt-black-900 text-center mb-6"
    >
      Sahkan Kata Laluan Anda
    </h1>

    <div class="mb-4 myds-body-sm text-txt-black-600 text-center">
      {{ __('Ini adalah kawasan selamat aplikasi. Sila sahkan kata laluan anda sebelum meneruskan.') }}
    </div>

    <!-- Password -->
    <div class="myds-form-group">
      <x-myds.input
        type="password"
        id="password"
        name="password"
        label="Kata Laluan"
        required
        autocomplete="current-password"
        aria-describedby="password-error"
      />
      <x-input-error
        :messages="$errors->get('password')"
        class="mt-2"
        id="password-error"
      />
    </div>

    <div class="flex justify-end mt-6">
      <x-myds.button
        type="submit"
        variant="primary"
        aria-label="Sahkan kata laluan dan teruskan"
      >
        {{ __('Sahkan') }}
      </x-myds.button>
    </div>
  </form>
</x-guest-layout>
