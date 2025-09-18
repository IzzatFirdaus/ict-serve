<x-guest-layout>
    <div class="text-center space-y-6">
        <h1 class="myds-heading-md text-txt-black-900 mb-6">Sahkan Alamat E-mel Anda</h1>

        <div class="mb-4 myds-body-sm text-txt-black-600">
            {{ __('Terima kasih kerana mendaftar! Sebelum meneruskan, sila sahkan alamat e-mel anda dengan mengklik pautan yang dihantar ke e-mel anda. Jika anda tidak menerima e-mel tersebut, kami akan menghantar semula.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 myds-body-sm text-txt-success p-4 bg-bg-success-50 border border-otl-success-200 rounded-[var(--radius-m)]" role="status">
                <svg class="inline w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ __('Pautan pengesahan baharu telah dihantar ke alamat e-mel anda.') }}
            </div>
        @endif

        <div class="mt-6 flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0 sm:space-x-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <x-myds.button
                    type="submit"
                    variant="primary"
                    aria-label="Hantar semula e-mel pengesahan">
                    {{ __('Hantar Semula E-mel Pengesahan') }}
                </x-myds.button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="myds-body-sm text-txt-primary hover:text-txt-primary underline focus:outline-none focus:ring-2 focus:ring-fr-primary focus:ring-offset-2 rounded-md transition-colors"
                        aria-label="Log keluar dari akaun anda">
                    {{ __('Log Keluar') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
