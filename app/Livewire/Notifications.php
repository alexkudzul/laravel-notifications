<?php

namespace App\Livewire;

use Livewire\Component;

class Notifications extends Component
{
    /**
     * Mark notifications as read
     */
    public function readNotification($id)
    {
        auth()->user()->notifications->find($id)->markAsRead();
    }

    public function render()
    {
        return view('livewire.notifications');
    }
}
