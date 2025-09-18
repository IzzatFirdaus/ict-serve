<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;

class App extends Component
{
    public $currentView = 'dashboard';

    public $user;

    public function mount()
    {
        $this->user = auth()->user();
        if (! $this->user) {
            return redirect()->route('login');
        }
    }

    public function setCurrentView($view)
    {
        $this->currentView = $view;
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.app');
    }
}
