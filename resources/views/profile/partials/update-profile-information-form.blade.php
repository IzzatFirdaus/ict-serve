{{--
  Partial: Update Profile Information Form
  Updated to use standard HTML with MYDS classes and Bahasa Melayu text.
--}}
<section>
  <header>
    <h2
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
    action="{{ route('verification.send') }}"
  >
    @csrf
  </form>

  <form
    method="post"
    action="{{ route('profile.update') }}"
    class="mt-6 space-y-6"
  >
    @csrf
    @method('patch')

    {{-- Name Field --}}
    <div>
      <label
        for="name"
        class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
      >
        Nama
      </label>
      <input
        id="name"
        name="name"
        type="text"
        value="{{ old('name', $user->name) }}"
        required
        autofocus
        autocomplete="name"
        class="mt-1 block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary"
      />
      @error('name')
        <p class="mt-2 text-sm text-txt-danger">{{ $message }}</p>
      @enderror
    </div>

    {{-- Email Field --}}
    <div>
      <label
        for="email"
        class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
      >
        E-mel
      </label>
      <input
        id="email"
        name="email"
        type="email"
        value="{{ old('email', $user->email) }}"
        required
        autocomplete="username"
        class="mt-1 block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary"
      />
      @error('email')
        <p class="mt-2 text-sm text-txt-danger">{{ $message }}</p>
      @enderror

      @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="mt-2">
          <p class="text-sm text-txt-black-800 dark:text-txt-black-200">
            Alamat e-mel anda belum disahkan.
            <button
              form="send-verification"
              class="underline text-sm text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fr-primary"
            >
              Klik di sini untuk menghantar semula e-mel pengesahan.
            </button>
          </p>

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
      <button type="submit" class="myds-btn myds-btn-primary">Simpan</button>

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
