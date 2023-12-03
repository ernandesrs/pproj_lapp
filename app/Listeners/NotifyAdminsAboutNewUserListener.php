<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\UserRegisteredNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdminsAboutNewUserListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        \Notification::send(User::whereHas('roles')->get(), new UserRegisteredNotification);
    }
}
