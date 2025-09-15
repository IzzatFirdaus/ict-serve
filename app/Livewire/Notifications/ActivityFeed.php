<?php

namespace App\Livewire\Notifications;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * @property \Illuminate\Contracts\Pagination\LengthAwarePaginator $activities
 */
class ActivityFeed extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $showFilters = false;

    public $selectedTypes = [];

    public $dateFrom = null;

    public $dateTo = null;

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->selectedTypes = $this->getAllActivityTypes();
    }

    #[On('activity-logged')]
    public function activityLogged($activity)
    {
        // Refresh the activity feed when new activity is logged
        $this->resetPage();
        $this->dispatch('toast', [
            'type' => 'info',
            'title' => 'Aktiviti Baru',
            'message' => 'Aktiviti baru telah direkodkan.',
        ]);
    }

    public function toggleFilters()
    {
        $this->showFilters = ! $this->showFilters;
    }

    public function resetFilters()
    {
        $this->selectedTypes = $this->getAllActivityTypes();
        $this->dateFrom = null;
        $this->dateTo = null;
        $this->resetPage();
    }

    public function applyFilters()
    {
        $this->resetPage();
        $this->showFilters = false;
    }

    public function updatedSelectedTypes()
    {
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    protected function getAllActivityTypes()
    {
        return [
            'loan_application',
            'loan_approval',
            'equipment_issued',
            'equipment_returned',
            'helpdesk_ticket',
            'ticket_assigned',
            'ticket_resolved',
            'system_login',
            'profile_updated',
        ];
    }

    protected function getActivityTypeLabel($type)
    {
        return match ($type) {
            'loan_application' => 'Permohonan Pinjaman',
            'loan_approval' => 'Kelulusan Pinjaman',
            'equipment_issued' => 'Peralatan Dikeluarkan',
            'equipment_returned' => 'Peralatan Dipulangkan',
            'helpdesk_ticket' => 'Tiket Helpdesk',
            'ticket_assigned' => 'Tiket Ditugaskan',
            'ticket_resolved' => 'Tiket Diselesaikan',
            'system_login' => 'Log Masuk Sistem',
            'profile_updated' => 'Profil Dikemaskini',
            default => ucfirst(str_replace('_', ' ', $type))
        };
    }

    protected function getActivityIcon($type)
    {
        return match ($type) {
            'loan_application' => 'document-add',
            'loan_approval' => 'check-circle',
            'equipment_issued' => 'download',
            'equipment_returned' => 'upload',
            'helpdesk_ticket' => 'chat-bubble',
            'ticket_assigned' => 'user',
            'ticket_resolved' => 'check',
            'system_login' => 'lock',
            'profile_updated' => 'edit',
            default => 'info'
        };
    }

    protected function getActivityColor($type)
    {
        return match ($type) {
            'loan_application' => 'primary',
            'loan_approval' => 'success',
            'equipment_issued' => 'warning',
            'equipment_returned' => 'success',
            'helpdesk_ticket' => 'primary',
            'ticket_assigned' => 'warning',
            'ticket_resolved' => 'success',
            'system_login' => 'black',
            'profile_updated' => 'primary',
            default => 'black'
        };
    }

    public function getActivitiesProperty()
    {
        $query = Auth::user()->activities()
            ->with(['subject', 'causer'])
            ->when($this->selectedTypes, function ($query) {
                return $query->whereIn('log_name', $this->selectedTypes);
            })
            ->when($this->dateFrom, function ($query) {
                return $query->whereDate('created_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                return $query->whereDate('created_at', '<=', $this->dateTo);
            })
            ->latest();

        return $query->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.notifications.activity-feed', [
            'activities' => $this->activities,
            'activityTypes' => $this->getAllActivityTypes(),
        ]);
    }
}
