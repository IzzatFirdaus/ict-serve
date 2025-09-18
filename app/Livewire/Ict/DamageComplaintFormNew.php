<?php

namespace App\Livewire\Ict;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\HelpdeskTicket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DamageComplaintFormNew extends Component
{
    // Form Reference
    public string $formReference = 'PK.(S).MOTAC.07.(L1)';

    // Form fields with validation
    #[Validate('required|string|min:2|max:255', message: [
        'required' => 'Nama penuh adalah wajib.',
        'min' => 'Nama penuh mestilah sekurang-kurangnya 2 aksara.',
        'max' => 'Nama penuh tidak boleh melebihi 255 aksara.'
    ])]
    public string $full_name = '';

    #[Validate('required|string', message: [
        'required' => 'Bahagian adalah wajib.',
    ])]
    public string $division = '';

    #[Validate('nullable|string|max:10')]
    public string $position_grade = '';

    #[Validate('required|email|max:255', message: [
        'required' => 'Alamat e-mel adalah wajib.',
        'email' => 'Format alamat e-mel tidak sah.',
        'max' => 'Alamat e-mel tidak boleh melebihi 255 aksara.'
    ])]
    public string $email = '';

    #[Validate('required|string|min:10|max:15|regex:/^(\+6)?[0-9\-\s]+$/', message: [
        'required' => 'Nombor telefon adalah wajib.',
        'min' => 'Nombor telefon mestilah sekurang-kurangnya 10 digit.',
        'max' => 'Nombor telefon tidak boleh melebihi 15 digit.',
        'regex' => 'Format nombor telefon tidak sah.'
    ])]
    public string $phone_number = '';

    #[Validate('required|string', message: [
        'required' => 'Jenis kerosakan adalah wajib.',
    ])]
    public string $damage_type = '';

    #[Validate('required|string|min:10|max:1000', message: [
        'required' => 'Maklumat kerosakan adalah wajib.',
        'min' => 'Maklumat kerosakan mestilah sekurang-kurangnya 10 aksara.',
        'max' => 'Maklumat kerosakan tidak boleh melebihi 1000 aksara.'
    ])]
    public string $damage_information = '';

    #[Validate('accepted', message: [
        'accepted' => 'Anda mesti bersetuju dengan perakuan untuk mengemukakan aduan.',
    ])]
    public bool $declaration_accepted = false;

    // Character counter
    public int $maxCharacters = 1000;

    // Available options
    public array $divisions = [
        'Bahagian Pengurusan ICT',
        'Bahagian Keselamatan ICT',
        'Bahagian Sokongan Teknikal',
        'Bahagian Pembangunan Sistem',
        'Bahagian Infrastruktur',
        'Lain-lain'
    ];

    public array $damageTypes = [
        'Kerosakan Perkakasan (Hardware)',
        'Masalah Perisian (Software)',
        'Masalah Rangkaian (Network)',
        'Masalah Printer/Pencetak',
        'Masalah Monitor/Skrin',
        'Masalah Sistem Operasi',
        'Lain-lain'
    ];

    // Loading states
    public bool $isSubmitting = false;

    public function mount(): void
    {
        // Pre-populate user data if authenticated
        if (Auth::check()) {
            $user = Auth::user();
            $this->full_name = $user->name ?? '';
            $this->email = $user->email ?? '';
        }
    }

    public function updatedDamageInformation(): void
    {
        // Real-time character count update
        $this->dispatch('character-count-updated', count: strlen($this->damage_information));
    }

    public function submit()
    {
        $this->isSubmitting = true;

        try {
            // Validate all fields
            $this->validate();

            // Create helpdesk ticket
            $ticket = HelpdeskTicket::create([
                'reference_code' => $this->generateReferenceCode(),
                'reporter_name' => $this->full_name,
                'reporter_email' => $this->email,
                'reporter_phone' => $this->phone_number,
                'division' => $this->division,
                'position_grade' => $this->position_grade ?: null,
                'damage_type' => $this->damage_type,
                'description' => $this->damage_information,
                'status' => 'pending',
                'priority' => 'medium',
                'user_id' => Auth::id(),
                'created_at' => now(),
            ]);

            // Show success message
            $this->dispatch('show-toast', [
                'type' => 'success',
                'title' => 'Aduan Berjaya Dihantar',
                'message' => "Kod rujukan anda: {$ticket->reference_code}. Anda akan menerima maklum balas dalam masa 24 jam."
            ]);

            // Reset form
            $this->resetForm();

            // Redirect to ticket view or dashboard
            return redirect()->route('helpdesk-tickets.show', $ticket->reference_code);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'title' => 'Ralat Validasi',
                'message' => 'Sila semak maklumat yang dimasukkan dan cuba lagi.'
            ]);
        } catch (\Exception $e) {
            logger()->error('Damage complaint form submission failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);

            $this->dispatch('show-toast', [
                'type' => 'error',
                'title' => 'Ralat Sistem',
                'message' => 'Maaf, terdapat masalah teknikal. Sila cuba lagi atau hubungi pentadbir sistem.'
            ]);
        } finally {
            $this->isSubmitting = false;
        }
    }

    private function generateReferenceCode(): string
    {
        $prefix = 'ICT-DMG-';
        $date = now()->format('Ymd');
    $sequence = str_pad((string)(HelpdeskTicket::whereDate('created_at', today())->count() + 1), 4, '0', STR_PAD_LEFT);

        return "{$prefix}{$date}-{$sequence}";
    }

    private function resetForm(): void
    {
        $this->full_name = '';
        $this->division = '';
        $this->position_grade = '';
        $this->email = '';
        $this->phone_number = '';
        $this->damage_type = '';
        $this->damage_information = '';
        $this->declaration_accepted = false;
    }

    public function render()
    {
        return view('livewire.ict.damage-complaint-form');
    }
}
