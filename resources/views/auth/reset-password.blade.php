<x-guest-layout>
  <form
    method="POST"
    action="{{ route('password.store') }}"
    class="space-y-6"
    role="form"
    aria-labelledby="reset-password-heading"
  >
    @csrf

    <!-- Password Reset Token -->
    <input type="hidden" name="token" value="{{ $request->route('token') }}" />

    <h1
      id="reset-password-heading"
      class="myds-heading-md text-txt-black-900 text-center mb-6"
    >
      Tetapkan Kata Laluan Baharu
    </h1>

    <!-- Email Address -->
    <div class="myds-form-group">
      <x-myds.input
        type="email"
        id="email"
        name="email"
        label="Alamat E-mel"
        :value="old('email', $request->email)"
        required
        autofocus
        autocomplete="username"
        readonly
        aria-describedby="email-error"
      />
      <x-input-error
        :messages="$errors->get('email')"
        class="mt-2"
        id="email-error"
      />
    </div>

    <!-- Password -->
    <div class="myds-form-group">
      <x-myds.input
        type="password"
        id="password"
        name="password"
        label="Kata Laluan Baharu"
        required
        autocomplete="new-password"
        aria-describedby="password-error password-help"
      />
      <p id="password-help" class="myds-body-xs text-txt-black-500 mt-1">
        Kata laluan mesti sekurang-kurangnya 8 aksara
      </p>
      <x-input-error
        :messages="$errors->get('password')"
        class="mt-2"
        id="password-error"
      />
    </div>

    <!-- Confirm Password -->
    <div class="myds-form-group">
      <x-myds.input
        type="password"
        id="password_confirmation"
        name="password_confirmation"
        label="Sahkan Kata Laluan Baharu"
        required
        autocomplete="new-password"
        aria-describedby="password-confirmation-error"
      />
      <x-input-error
        :messages="$errors->get('password_confirmation')"
        class="mt-2"
        id="password-confirmation-error"
      />
    </div>

    <div class="flex items-center justify-center mt-6">
      <x-myds.button
        type="submit"
        variant="primary"
        aria-label="Tetapkan semula kata laluan anda"
      >
        {{ __('Tetapkan Semula Kata Laluan') }}
      </x-myds.button>
    </div>
  </form>
</x-guest-layout>
