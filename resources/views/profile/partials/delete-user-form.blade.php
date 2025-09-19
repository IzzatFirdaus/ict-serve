{{--
  Partial: Delete User Form
  Updated to use standard HTML with MYDS classes, Bahasa Melayu text,
  and a custom modal styled as an MYDS 'Alert Dialog' powered by Alpine.js.
--}}
<section
  class="space-y-6"
  x-data="{
    showModal: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }},
  }"
>
  <header>
    <h2
      class="text-lg font-medium font-poppins text-txt-black-900 dark:text-white"
    >
      Padam Akaun
    </h2>
    <p class="mt-1 text-sm text-txt-black-600 dark:text-txt-black-400">
      Setelah akaun anda dipadamkan, semua sumber dan data akan dipadamkan
      secara kekal. Sebelum memadamkan akaun anda, sila muat turun sebarang data
      atau maklumat yang ingin anda simpan.
    </p>
  </header>

  <button
    @click="showModal = true"
    type="button"
    class="myds-btn myds-btn-danger"
  >
    Padam Akaun
  </button>

  {{-- Confirmation Modal (Styled as MYDS Alert Dialog) --}}
  <div
    x-show="showModal"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    x-trap.inert.noscroll="showModal"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
    x-cloak
  >
    {{-- Modal Backdrop --}}
    <div
      x-show="showModal"
      x-transition:enter="ease-out duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="ease-in duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      @click="showModal = false"
      class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"
    ></div>

    {{-- Modal Panel --}}
    <div
      x-show="showModal"
      x-transition:enter="ease-out duration-300"
      x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100"
      x-transition:leave="ease-in duration-200"
      x-transition:leave-start="opacity-100 scale-100"
      x-transition:leave-end="opacity-0 scale-95"
      class="relative w-full max-w-lg overflow-hidden rounded-lg bg-white dark:bg-gray-900 shadow-xl border border-otl-gray-200 dark:border-otl-gray-800"
    >
      <form method="post" action="{{ route('profile.destroy') }}">
        @csrf
        @method('delete')

        <div class="p-6">
          <h2
            id="modal-title"
            class="text-lg font-medium font-poppins text-txt-black-900 dark:text-white"
          >
            Adakah anda pasti ingin memadamkan akaun anda?
          </h2>
          <p class="mt-1 text-sm text-txt-black-600 dark:text-txt-black-400">
            Setelah akaun anda dipadamkan, semua datanya akan dipadamkan secara
            kekal. Sila masukkan kata laluan anda untuk mengesahkan anda ingin
            memadamkan akaun anda secara kekal.
          </p>

          <div class="mt-6">
            <label for="password" class="sr-only">Kata Laluan</label>
            <input
              id="password"
              name="password"
              type="password"
              placeholder="Kata Laluan"
              class="block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary"
            />
            @error('password', 'userDeletion')
              <p class="mt-2 text-sm text-txt-danger">{{ $message }}</p>
            @enderror
          </div>
        </div>

        {{-- Modal Footer with Actions --}}
        <div
          class="flex justify-end gap-4 bg-washed dark:bg-gray-950/50 px-6 py-4"
        >
          <button
            type="button"
            @click="showModal = false"
            class="myds-btn myds-btn-secondary"
          >
            Batal
          </button>
          <button type="submit" class="myds-btn myds-btn-danger">
            Padam Akaun
          </button>
        </div>
      </form>
    </div>
  </div>
</section>
