<?php

namespace App\Listeners\Account;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUpdatePasswordLinkListener
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
    public function handle(\App\Events\Account\ForgetPasswordEvent $event): void
    {
        \Mail::to($event->user->email, $event->user->first_name . ' ' . $event->user->last_name)
            ->queue(new \App\Mail\Account\UpdatePasswordMail($event->user, $event->reset));
    }
}