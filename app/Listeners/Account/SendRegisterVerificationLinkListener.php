<?php

namespace App\Listeners\Account;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRegisterVerificationLinkListener
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
    public function handle(\App\Events\Account\UserRegisteredEvent $event): void
    {
        \Mail::to($event->user, $event->user->first_name . ' ' . $event->user->last_name)
            ->queue(new \App\Mail\Account\VerifyAccountMail($event->user));
    }
}