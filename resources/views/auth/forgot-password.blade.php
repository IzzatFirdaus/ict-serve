<x-guest-layout>
  <div class="mb-6">
    <h1 class="myds-heading-md text-txt-black-900 text-center mb-4">
      Tetapkan Semula Kata Laluan
    </h1>
    <p class="myds-body-sm text-txt-black-700 text-center">
      {{ __('Terlupa kata laluan anda? Masukkan alamat emel berdaftar dan kami akan menghantar pautan untuk tetapkan semula kata laluan anda.') }}
    </p>
  </div>

  <!-- Session Status -->
  <x-auth-session-status class="mb-4" :status="session('status')" />

  <form
    method="POST"
    action="{{ route('password.email') }}"
    class="space-y-6"
    role="form"
    aria-labelledby="reset-password-heading"
  >
    @csrf

    <div id="reset-password-heading" class="sr-only">
      Borang Tetapan Semula Kata Laluan
    </div>

    <!-- Email Address -->
    <div class="myds-form-group">
      <x-myds.input
        type="email"
        id="email"
        name="email"
        label="Alamat E-mel"
        :value="old('email')"
        required
        autofocus
        aria-describedby="email-error"
        placeholder="Masukkan alamat emel berdaftar"
      />
      <x-input-error
        :messages="$errors->get('email')"
        class="mt-2"
        id="email-error"
      />
    </div>

    <div class="flex items-center justify-center mt-6">
      <x-myds.button
        type="submit"
        variant="primary"
        aria-label="Hantar pautan tetapan semula kata laluan ke emel anda"
      >
        {{ __('Hantar Pautan Reset Kata Laluan') }}
      </x-myds.button>
    </div>

    <div class="text-center mt-4">
      <a
        class="myds-body-sm text-txt-primary hover:text-txt-primary underline focus:outline-none focus:ring-2 focus:ring-fr-primary focus:ring-offset-2 rounded-md"
        href="{{ route('login') }}"
        aria-label="Kembali ke halaman log masuk"
      >
        {{ __('Kembali ke Log Masuk') }}
      </a>
    </div>
  </form>
</x-guest-layout>
