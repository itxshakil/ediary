<?php

namespace App\Providers;

use App\Events\PasswordChanged;
use App\Events\ProfilePicChanged;
use App\Events\UsernameChanged;
use App\Listeners\DeleteOldPic;
use App\Listeners\SendPasswordChangedNotification;
use App\Listeners\SendUsernameChangedNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PasswordChanged::class => [
            SendPasswordChangedNotification::class,
        ],
        ProfilePicChanged::class => [
            DeleteOldPic::class,
        ],
        UsernameChanged::class => [
            SendUsernameChangedNotification::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
