<?php

namespace App\Livewire;

use Livewire\Component;

class FeedbackToast extends Component
{
    public $show = false;
    public $message = '';

    protected $listeners = [
        'showToast' => 'showToast',
    ];

    public function showToast($message)
    {
        $this->message = $message;
        $this->show = true;
        $this->dispatch('toast-shown');
    }

    public function render()
    {
        return view('livewire.feedback-toast');
    }
}
