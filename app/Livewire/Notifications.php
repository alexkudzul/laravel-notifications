<?php

namespace App\Livewire;

use Livewire\Component;

class Notifications extends Component
{
    public $amountNotificationsToShow = 3;


    /**
     * Listening Notifications with Laravel Echo and Livewire.
     *
     * Livewire V2: https://laravel-livewire.com/docs/2.x/laravel-echo
     * Livewire V3: https://livewire.laravel.com/docs/events#real-time-events-using-laravel-echo
     */
    public function getListeners()
    {
        return [
            'echo-notification:App.Models.User.' . auth()->user()->id . ',MessageSent' => 'render',
        ];
    }

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
