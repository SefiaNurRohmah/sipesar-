<?php

namespace App\Providers;

use App\Events\UserRegistered;
use App\Listeners\SendNewRegistrationNotification;
use App\Events\RegistrationStatusUpdated;
use App\Listeners\SendRegistrationVerifiedNotification;
use App\Events\AnnouncementCreated;
use App\Listeners\SendNewAnnouncementNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            UserRegistered::class,
            [SendNewRegistrationNotification::class, 'handle']
        );

        // Event::listen(
        //     RegistrationStatusUpdated::class,
        //     [SendRegistrationVerifiedNotification::class, 'handle']
        // );

        // Event::listen(
        //     AnnouncementCreated::class,
        //     [SendNewAnnouncementNotification::class, 'handle']
        // );
    }
}