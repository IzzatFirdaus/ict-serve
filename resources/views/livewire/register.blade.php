{{--
  ICTServe (iServe) User Registration Component
  =============================================
  This component provides a full user registration form, replacing the basic one.
  It is designed to capture all necessary user information as per the application's database schema.
  
  MYDS & MyGovEA Principles Applied:
  - Berpaksikan Rakyat (Citizen-Centric): The form uses clear, Malay-language labels and placeholders, guiding the user through the registration process.
  - Kandungan Terancang (Planned Content): Fields are logically grouped into "Maklumat Peribadi" (Personal Information), "Maklumat Organisasi" (Organizational Information), and "Maklumat Keselamatan" (Security Information).
  - Pencegahan Ralat (Error Prevention): Employs real-time validation with `wire:model.live` and provides clear error messages using the `@error` directive. The submit button is disabled during processing.
  - Seragam (Consistent): All elements use MYDS tokens for styling, including inputs, selects, buttons, and typography, ensuring visual consistency with the rest of the application.
  - Aksesibiliti: Proper use of `<label for="...">`, ARIA attributes, and visible focus rings (`focus:ring-fr-primary`) ensures the form is accessible.
--}}

<div class="max-w-2xl mx-auto px-4 py-8 sm:px-6 lg:px-8 font-inter">
  {{-- Card component using MYDS styling for a consistent look and feel --}}
  <div
    class="bg-white dark:bg-gray-900 border border-otl-gray-200 dark:border-otl-gray-800 rounded-lg shadow-card"
  >
    <div class="p-6 border-b border-otl-divider dark:border-otl-divider">
      <h2
        class="text-2xl font-semibold font-poppins text-txt-black-900 dark:text-white text-center"
      >
        Pendaftaran Akaun Baru
      </h2>
      <p
        class="mt-2 text-sm text-txt-black-500 dark:text-txt-black-400 text-center"
      >
        Sila lengkapkan maklumat di bawah untuk mendaftar.
      </p>
    </div>

    <form wire:submit.prevent="register">
      <div class="p-6 space-y-6">
        {{-- Section 1: Personal Information --}}
        <fieldset class="space-y-4">
          <legend
            class="text-lg font-medium font-poppins text-txt-black-800 dark:text-txt-black-200"
          >
            Maklumat Peribadi
          </legend>

          <div>
            <label
              for="name"
              class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
            >
              Nama Penuh
            </label>
            <input
              id="name"
              type="text"
              wire:model.live="name"
              required
              autofocus
              autocomplete="name"
              class="mt-1 block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary"
              placeholder="Seperti dalam MyKad"
            />
            @error('name')
              <span class="text-sm text-txt-danger">{{ $message }}</span>
            @enderror
          </div>

          <div>
            <label
              for="email"
              class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
            >
              Alamat E-mel Rasmi
            </label>
            <input
              id="email"
              type="email"
              wire:model.live="email"
              required
              autocomplete="email"
              class="mt-1 block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary"
              placeholder="nama@agensi.gov.my"
            />
            @error('email')
              <span class="text-sm text-txt-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label
                for="identification_number"
                class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
              >
                No. Kad Pengenalan
              </label>
              <input
                id="identification_number"
                type="text"
                wire:model.live="identification_number"
                required
                class="mt-1 block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary"
                placeholder="Cth: 800101-10-1234"
              />
              @error('identification_number')
                <span class="text-sm text-txt-danger">{{ $message }}</span>
              @enderror
            </div>
            <div>
              <label
                for="mobile_number"
                class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
              >
                No. Telefon Bimbit
              </label>
              <input
                id="mobile_number"
                type="text"
                wire:model.live="mobile_number"
                required
                class="mt-1 block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary"
                placeholder="Cth: 012-3456789"
              />
              @error('mobile_number')
                <span class="text-sm text-txt-danger">{{ $message }}</span>
              @enderror
            </div>
          </div>
        </fieldset>

        {{-- Section 2: Organizational Information --}}
        <fieldset
          class="space-y-4 pt-4 border-t border-otl-divider dark:border-otl-divider"
        >
          <legend
            class="text-lg font-medium font-poppins text-txt-black-800 dark:text-txt-black-200"
          >
            Maklumat Organisasi
          </legend>

          {{-- Note: These dropdowns should be populated from the database via the Livewire component class --}}
          <div>
            <label
              for="department_id"
              class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
            >
              Jabatan / Bahagian
            </label>
            <select
              id="department_id"
              wire:model.live="department_id"
              required
              class="mt-1 block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary"
            >
              <option value="">-- Sila Pilih Jabatan --</option>
              {{--
                @foreach($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
              --}}
              <option value="1">Bahagian Pengurusan Maklumat (Contoh)</option>
            </select>
            @error('department_id')
              <span class="text-sm text-txt-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label
                for="position_id"
                class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
              >
                Jawatan
              </label>
              <select
                id="position_id"
                wire:model.live="position_id"
                required
                class="mt-1 block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary"
              >
                <option value="">-- Sila Pilih Jawatan --</option>
                {{--
                  @foreach($positions as $position)
                  <option value="{{ $position->id }}">{{ $position->name }}</option>
                  @endforeach
                --}}
                <option value="1">Pegawai Teknologi Maklumat (Contoh)</option>
              </select>
              @error('position_id')
                <span class="text-sm text-txt-danger">{{ $message }}</span>
              @enderror
            </div>
            <div>
              <label
                for="grade_id"
                class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
              >
                Gred
              </label>
              <select
                id="grade_id"
                wire:model.live="grade_id"
                required
                class="mt-1 block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary"
              >
                <option value="">-- Sila Pilih Gred --</option>
                {{--
                  @foreach($grades as $grade)
                  <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                  @endforeach
                --}}
                <option value="1">F41 (Contoh)</option>
                <option value="2">F44 (Contoh)</option>
              </select>
              @error('grade_id')
                <span class="text-sm text-txt-danger">{{ $message }}</span>
              @enderror
            </div>
          </div>
        </fieldset>

        {{-- Section 3: Security Information --}}
        <fieldset
          class="space-y-4 pt-4 border-t border-otl-divider dark:border-otl-divider"
        >
          <legend
            class="text-lg font-medium font-poppins text-txt-black-800 dark:text-txt-black-200"
          >
            Maklumat Keselamatan
          </legend>

          <div>
            <label
              for="password"
              class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
            >
              Kata Laluan
            </label>
            <input
              id="password"
              type="password"
              wire:model.live="password"
              required
              autocomplete="new-password"
              class="mt-1 block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary"
            />
            @error('password')
              <span class="text-sm text-txt-danger">{{ $message }}</span>
            @enderror
          </div>

          <div>
            <label
              for="password_confirmation"
              class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
            >
              Sahkan Kata Laluan
            </label>
            <input
              id="password_confirmation"
              type="password"
              wire:model.live="password_confirmation"
              required
              autocomplete="new-password"
              class="mt-1 block w-full rounded-md border-otl-gray-300 dark:border-otl-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring focus:ring-fr-primary"
            />
            @error('password_confirmation')
              <span class="text-sm text-txt-danger">{{ $message }}</span>
            @enderror
          </div>
        </fieldset>
      </div>

      <div
        class="flex flex-col items-center justify-between p-6 bg-washed dark:bg-gray-950/50 border-t border-otl-divider dark:border-otl-divider rounded-b-lg"
      >
        <button
          type="submit"
          wire:loading.attr="disabled"
          class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fr-primary disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <svg
            wire:loading
            wire:target="register"
            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
            xmlns="http://www.w.org/2000/svg"
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
          <span wire:loading.remove>Daftar Akaun</span>
          <span wire:loading>Mendaftar...</span>
        </button>

        <div class="mt-4 text-sm">
          <a
            href="{{ route('login') }}"
            class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300"
          >
            Sudah mempunyai akaun? Log masuk
          </a>
        </div>
      </div>
    </form>
  </div>
</div>
