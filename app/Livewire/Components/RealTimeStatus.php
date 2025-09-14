<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;

class RealTimeStatus extends Component
{
    public $title = '';
    public $items = [];
    public $refreshInterval = 30; // seconds
    public $autoRefresh = true;

    protected $listeners = [
        'statusUpdate' => 'handleStatusUpdate',
        'refreshStatus' => 'refreshData',
    ];

    public function mount($title = 'Status Dashboard', $autoRefresh = true, $refreshInterval = 30)
    {
        $this->title = $title;
        $this->autoRefresh = $autoRefresh;
        $this->refreshInterval = $refreshInterval;
        $this->loadInitialData();

        if ($this->autoRefresh) {
            $this->dispatch('startAutoRefresh', $this->refreshInterval);
        }
    }

    public function loadInitialData()
    {
        // This method should be overridden by child components
        $this->items = $this->getStatusData();
    }

    public function refreshData()
    {
        $this->items = $this->getStatusData();
        $this->dispatch('statusRefreshed');
    }

    #[On('statusUpdate')]
    public function handleStatusUpdate($data)
    {
        // Handle real-time status updates
        $this->refreshData();

        // Show toast notification if significant change
        if (isset($data['notify']) && $data['notify']) {
            $this->dispatch('showToast', [
                'type' => $data['type'] ?? 'info',
                'title' => $data['title'] ?? 'Status Dikemaskini',
                'message' => $data['message'] ?? 'Status sistem telah dikemaskini.',
            ]);
        }
    }

    public function toggleAutoRefresh()
    {
        $this->autoRefresh = !$this->autoRefresh;

        if ($this->autoRefresh) {
            $this->dispatch('startAutoRefresh', $this->refreshInterval);
        } else {
            $this->dispatch('stopAutoRefresh');
        }
    }

    public function forceRefresh()
    {
        $this->refreshData();
        $this->dispatch('showToast', [
            'type' => 'success',
            'message' => 'Status telah dimuat semula.',
        ]);
    }

    protected function getStatusData()
    {
        // Default implementation - should be overridden
        return [
            [
                'id' => 'system',
                'label' => 'Status Sistem',
                'value' => 'Operasi Normal',
                'type' => 'system',
                'status' => 'active',
                'updated_at' => now(),
            ],
        ];
    }

    public function render()
    {
        return view('livewire.components.real-time-status');
    }
}
