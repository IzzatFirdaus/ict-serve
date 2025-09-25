{{--
  Partial: Update Profile Information Form
  Updated to use standard HTML with MYDS classes and Bahasa Melayu text.
--}}
<section>
  <header>
    <h2
      id="profile-information-heading"
      class="text-lg font-medium font-poppins text-txt-black-900 dark:text-white"
    >
      Maklumat Profil
    </h2>

    <p class="mt-1 text-sm text-txt-black-600 dark:text-txt-black-400">
      Kemaskini maklumat profil dan alamat e-mel akaun anda.
    </p>
  </header>

  {{-- This form is used to trigger the email verification flow --}}
  <form
    id="send-verification"
    method="post"
          <x-ictserve.form-input
  >
    @csrf
  </form>

  <form
    method="post"
    action="{{ route('profile.update') }}"
    class="mt-6 space-y-6"
    role="form"
    aria-labelledby="profile-information-heading"
  >
    @csrf
    @method('patch')

    {{-- Name Field --}}
    <div>
      <x-myds.form-input
        id="name"
        name="name"
        label="Nama"
        type="text"
        :value="old('name', $user->name)"
        required
        autofocus
        autocomplete="name"
        error="{{ $errors->first('name') }}"
      />
    </div>

    {{-- Email Field --}}
    <div>
      <x-myds.form-input
        id="email"
        name="email"
        label="E-mel"
        type="email"
        :value="old('email', $user->email)"
        required
        autocomplete="username"
        error="{{ $errors->first('email') }}"
              <x-ictserve.button

      @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="mt-2">
          <p class="text-sm text-txt-black-800 dark:text-txt-black-200">
            Alamat e-mel anda belum disahkan.
            <x-myds.button
              form="send-verification"
              variant="outline"
              size="sm"
              class="inline-block align-baseline ml-2"
            >
              Klik di sini untuk menghantar semula e-mel pengesahan.
            </x-myds.button>
          </p>
          <x-ictserve.button type="submit" variant="primary">Simpan</x-ictserve.button>
          @if (session('status') === 'verification-link-sent')
            <p
              class="mt-2 font-medium text-sm text-txt-success dark:text-success-400"
            >
              Pautan pengesahan baharu telah dihantar ke alamat e-mel anda.
            </p>
          @endif
        </div>
      @endif
    </div>

    {{-- Actions --}}
    <div class="flex items-center gap-4">
      <x-myds.button type="submit" variant="primary">Simpan</x-myds.button>

      @if (session('status') === 'profile-updated')
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
