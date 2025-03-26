<?php

namespace App\Listeners;

use App\Events\ClientLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogClientLogin
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
    public function handle(ClientLogin $event): void
    {
        //
        Log::info("Client Logged In: " . $event->client->email);
    }
}
