<?php

namespace App\Events;

use App\Models\Registration;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RegistrationStatusUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $registration;

    /**
     * Create a new event instance.
     */
    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }
}