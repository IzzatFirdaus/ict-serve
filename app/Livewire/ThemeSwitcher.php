<?php

namespace App\Livewire;

use Livewire\Component;

class ThemeSwitcher extends Component
{
    public $theme = 'system';

    public function mount()
    {
        $this->theme = session('theme', 'system');
    }

    public function updatedTheme($value)
    {
        session(['theme' => $value]);
        $this->dispatch('theme-changed', message: trans('messages.theme_changed_' . $value));
    }

    public function render()
    {
        return view('livewire.theme-switcher');
    }
}
