<?php

namespace App\Livewire;

use Livewire\Component;

class LanguageSwitcher extends Component
{
    public $language = 'ms';

    public function mount()
    {
        $this->language = session('locale', 'ms');
    }

    public function updatedLanguage($value)
    {
        session(['locale' => $value]);
        app()->setLocale($value);
        $this->dispatch('language-changed', message: trans('messages.language_changed_' . $value));
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
