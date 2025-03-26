<?php

namespace App\Listeners;

use App\Events\ClientRegister;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class SendWelcomeEmail
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
    public function handle(ClientRegister $event): void
    {
        //
        Mail::to($event->user->email)->send(new WelcomeMail($event->user));
    }
}
