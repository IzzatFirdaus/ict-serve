{{-- Notification Widget - MYDS Compliant --}}
<div class="bg-white rounded-lg border border-divider p-6">
    <h3 class="font-poppins text-lg font-medium text-black-900 mb-4 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 6h16M4 12h16m-7 6h7"/>
        </svg>
        Notifikasi Terkini
    </h3>

    @if(count($notifications) > 0)
        <div class="space-y-3">
            @foreach($notifications as $notification)
                <div class="p-3 border border-divider rounded-md {{ $notification['type'] === 'success' ? 'bg-success-50 border-success-200' : 'bg-background-light' }}">
                    <div class="flex items-start gap-3">
                        @if($notification['type'] === 'success')
                            <svg class="w-4 h-4 text-success-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4 text-primary-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @endif
                        <div class="flex-1">
                            <h4 class="font-inter text-sm font-medium text-black-900">{{ $notification['title'] }}</h4>
                            <p class="font-inter text-xs text-black-700">{{ $notification['message'] }}</p>
                            <p class="font-inter text-xs text-black-500 mt-1">{{ $notification['time'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            <button 
                type="button" 
                class="w-full inline-flex justify-center items-center px-4 py-2 border border-divider text-sm font-inter font-medium rounded-md text-black-700 dark:text-black-300 bg-white dark:bg-dialog hover:bg-washed dark:hover:bg-black-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200"
            >
                Lihat Semua
            </button>
        </div>
    @else
        <div class="text-center py-6">
            <svg class="w-6 h-6 text-black-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 6h16M4 12h16m-7 6h7"/>
            </svg>
            <p class="font-inter text-sm text-black-500 mt-2">Tiada notifikasi baharu</p>
        </div>
    @endif
</div>
