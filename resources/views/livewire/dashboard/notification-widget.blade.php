{{-- Notification Widget - MYDS Compliant --}}
<div class="bg-white rounded-lg border border-divider p-6">
    <h3 class="font-poppins text-lg font-medium text-black-900 mb-4 flex items-center gap-2">
        <x-myds.icon svg='<svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>' />
        Notifikasi Terkini
    </h3>

    @if(count($notifications) > 0)
        <div class="space-y-3">
            @foreach($notifications as $notification)
                <div class="p-3 border border-divider rounded-md {{ $notification['type'] === 'success' ? 'bg-success-50 border-success-200' : 'bg-background-light' }}">
                    <div class="flex items-start gap-3">
                        @if($notification['type'] === 'success')
                            <x-myds.icon svg='<svg width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="9,11 12,14 22,4"/></svg>' :size="16" />
                        @else
                            <x-myds.icon svg='<svg width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>' :size="16" />
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
            <x-myds.button variant="secondary" class="w-full text-sm" aria-label="Lihat Semua Notifikasi">
                Lihat Semua
            </x-myds.button>
        </div>
    @else
        <div class="text-center py-6">
            <x-myds.icon svg='<svg width="24" height="24" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>' :size="24" />
            <p class="font-inter text-sm text-black-500 mt-2">Tiada notifikasi baharu</p>
        </div>
    @endif
</div>
