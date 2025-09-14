{{-- Quick Access Widget - MYDS Compliant --}}
<div class="bg-white rounded-lg border border-divider p-6">
    <h3 class="font-poppins text-lg font-medium text-black-900 mb-4 flex items-center gap-2">
        <x-myds.icon svg='<svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="14" height="14" rx="2" ry="2"/><line x1="9" y1="9" x2="15" y2="9"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="5" y1="9" x2="5" y2="9.01"/><line x1="5" y1="13" x2="5" y2="13.01"/></svg>' />
        Akses Pantas
    </h3>

    <div class="space-y-3">
        {{-- Equipment Loan Quick Access --}}
        <x-myds.button
            variant="primary"
            class="w-full justify-start"
            wire:click="navigateToLoanApplication"
            aria-label="Permohonan Pinjaman Peralatan ICT">
            <x-slot name="icon">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="3" y="4" width="14" height="14" rx="2" ry="2"/>
                    <line x1="7" y1="8" x2="13" y2="8"/>
                    <line x1="7" y1="12" x2="13" y2="12"/>
                    <line x1="7" y1="16" x2="13" y2="16"/>
                </svg>
            </x-slot>
            Permohonan Pinjaman ICT
        </x-myds.button>

        {{-- Helpdesk Quick Access --}}
        <x-myds.button
            variant="secondary"
            class="w-full justify-start"
            wire:click="navigateToHelpdeskTicket"
            aria-label="Aduan Helpdesk ICT">
            <x-slot name="icon">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </x-slot>
            Aduan Helpdesk ICT
        </x-myds.button>

        {{-- View Status Quick Access --}}
        <x-myds.button
            variant="secondary"
            class="w-full justify-start"
            aria-label="Lihat Status Permohonan">
            <x-slot name="icon">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </x-slot>
            Lihat Status
        </x-myds.button>
    </div>
</div>
