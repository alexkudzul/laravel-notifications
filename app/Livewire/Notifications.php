<?php

namespace App\Livewire;

use Livewire\Component;

class Notifications extends Component
{
    public $amountNotificationsToShow = 3;

    /**
     * Computed Property
     */
    public function getNotificationsProperty()
    {
        return auth()->user()->notifications->take($this->amountNotificationsToShow);
    }

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

    public function incrementAmountNotificationsToShow()
    {
        $this->amountNotificationsToShow += 3;
    }

    public function render()
    {
        return view('livewire.notifications');
    }
}
