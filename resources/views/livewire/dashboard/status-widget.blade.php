{{-- Status Widget - MYDS Compliant --}}
<div class="bg-white rounded-lg border border-divider p-6">
    <h3 class="font-poppins text-lg font-medium text-black-900 mb-4 flex items-center gap-2">
        <x-myds.icon svg='<svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>' />
        Status Ringkasan
    </h3>

    <div class="space-y-4">
        {{-- Pending Loans Status --}}
        <div class="flex items-center justify-between p-3 bg-warning-50 rounded-md border border-warning-200">
            <div class="flex items-center gap-3">
                <x-myds.icon svg='<svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="3"/><path d="M12 1v6m0 6v6m11-7h-6m-6 0H1"/></svg>' />
                <span class="font-inter text-sm text-warning-700">Pinjaman Menunggu</span>
            </div>
            <span class="bg-warning-600 text-white px-2 py-1 rounded-full text-xs font-medium">{{ $pendingLoans }}</span>
        </div>

        {{-- Open Tickets Status --}}
        <div class="flex items-center justify-between p-3 bg-danger-50 rounded-md border border-danger-200">
            <div class="flex items-center gap-3">
                <x-myds.icon svg='<svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>' />
                <span class="font-inter text-sm text-danger-700">Tiket Terbuka</span>
            </div>
            <span class="bg-danger-600 text-white px-2 py-1 rounded-full text-xs font-medium">{{ $openTickets }}</span>
        </div>

        {{-- Notifications Status --}}
        <div class="flex items-center justify-between p-3 bg-primary-50 rounded-md border border-primary-200">
            <div class="flex items-center gap-3">
                <x-myds.icon svg='<svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>' />
                <span class="font-inter text-sm text-primary-700">Notifikasi Baharu</span>
            </div>
            <span class="bg-primary-600 text-white px-2 py-1 rounded-full text-xs font-medium">{{ $notifications }}</span>
        </div>
    </div>
</div>
