<?php

namespace App\Listeners;

use App\Events\AnnouncementCreated;
use App\Models\User;
use App\Notifications\NewAnnouncement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewAnnouncementNotification
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
    public function handle(AnnouncementCreated $event): void
    {
        $students = User::where('role', 'siswa')->get();
        Notification::send($students, new NewAnnouncement($event->announcement));
    }
}