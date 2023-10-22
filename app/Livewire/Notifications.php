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

    /**
     * Reset new notifications
     */
    public function resetNotification()
    {
        auth()->user()->notification = 0;
        auth()->user()->save();
    }

    public function render()
    {
        return view('livewire.notifications');
    }
}
