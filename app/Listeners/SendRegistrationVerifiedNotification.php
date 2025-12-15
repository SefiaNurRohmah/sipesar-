<?php

namespace App\Listeners;

use App\Events\RegistrationStatusUpdated;
use App\Notifications\RegistrationVerified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRegistrationVerifiedNotification
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
    public function handle(RegistrationStatusUpdated $event): void
    {
        $student = $event->registration->user; // Assuming Registration has a 'user' relationship
        if ($student) {
            $student->notify(new RegistrationVerified($event->registration));
        }
    }
}