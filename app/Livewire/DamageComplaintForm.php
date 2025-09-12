<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class DamageComplaintForm extends Component
{
    #[Rule('required|string|max:255')]
    public $full_name = '';

    #[Rule('required|string')]
    public $division = '';

    #[Rule('nullable|string|max:50')]
    public $position_grade = '';

    #[Rule('required|email|max:255')]
    public $email = '';

    #[Rule('required|string|max:20')]
    public $phone_number = '';

    #[Rule('required|string')]
    public $damage_type = '';

    #[Rule('required|string|min:10')]
    public $damage_info = '';

    #[Rule('nullable|string|max:100')]
    public $asset_number = '';

    #[Rule('required|accepted')]
    public $declaration = false;

    public function getDivisionOptions()
    {
        return [
            'BPM' => 'Bahagian Pengurusan Maklumat (BPM)',
            'BPPP' => 'Bahagian Pengurusan Perancangan dan Penyelidikan',
            'BPD' => 'Bahagian Pelancongan Domestik',
            'BPA' => 'Bahagian Pelancongan Antarabangsa',
            'BPP' => 'Bahagian Pembangunan Produk',
            'BSB' => 'Bahagian Seni dan Budaya',
            'BKIP' => 'Bahagian Korporat dan Integriti Pengurusan',
            'BKA' => 'Bahagian Kewangan dan Akaun',
            // Add more divisions as needed
        ];
    }

    public function getDamageTypeOptions()
    {
        return [
            'hardware-pc' => 'Perkakasan - PC, Laptop, Printer, Scanner, Projektor',
            'hardware-ipad' => 'Perkakasan - iPad',
            'hardware-toner' => 'Perkakasan - Permohonan Toner',
            'app-email' => 'Aplikasi - E-Mail, Anti Virus',
            'app-systems' => 'Aplikasi - iGFMAS, HRMIS, ePerolehan, GPKI',
            'app-web' => 'Aplikasi - Laman Web, INTRAnet',
            'app-attendance' => 'Aplikasi - Sistem Kehadiran (e-Jari)',
            'app-others' => 'Aplikasi - Lain-lain',
            'network-hq' => 'Network - Ibu Pejabat',
            'network-state' => 'Network - Pejabat Negeri',
            'others' => 'Lain-lain Aduan',
        ];
    }

    public function getShowAssetNumberProperty()
    {
        return in_array($this->damage_type, ['hardware-pc', 'hardware-ipad', 'hardware-toner']);
    }

    public function updatedDamageType()
    {
        if (!$this->show_asset_number) {
            $this->asset_number = '';
        }
    }

    public function updatedDeclaration()
    {
        // This will trigger UI updates for button visibility
    }

    public function submit()
    {
        // Add asset_number validation rule if needed
        if ($this->show_asset_number) {
            $this->rules['asset_number'] = 'required|string|max:100';
        }

        $this->validate();

        // Here you would typically save to database
        // For now, we'll just show a success message
        session()->flash('success', 'Aduan kerosakan ICT anda telah berjaya dihantar. Nombor rujukan: ICT-' . now()->format('YmdHis'));

        $this->reset();
    }

    public function resetForm()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.damage-complaint-form');
    }
}
