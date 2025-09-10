<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class App extends Component
{
    public $currentView = 'dashboard';

    public $user;

    public function mount()
    {
        $this->user = Auth::user();
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
        Auth::logout();

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.app');
    }
}
