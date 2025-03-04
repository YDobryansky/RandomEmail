<?php

namespace NotificationChannels\AbstractDriver;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

abstract class AbstractDriverServiceProvider extends ServiceProvider
{

    const CHANNEL = '';
    const DRIVER_SMS = '';
    const DRIVER_STATUS = '';

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Bootstrap code here.
        /**
         * Here's some example code we use for the pusher package.

        $this->app->when(Channel::class)
            ->needs(Pusher::class)
            ->give(function () {
                $pusherConfig = config('broadcasting.connections.pusher');

                return new Pusher(
                    $pusherConfig['key'],
                    $pusherConfig['secret'],
                    $pusherConfig['app_id']
                );
            });
         */
    }

    /**
     * Notification::resolved(static function (ChannelManager $service) {
     *  $service->extend(
     *      static::DRIVER_SMS,
     *      static fn ($app) => $app->make(AbstractDriverSmsChannel::class)
     *  );
     *  $service->extend(
     *      static::DRIVER_STATUS,
     *      static fn ($app) => $app->make(AbstractDriverCheckStatusChannel::class)
     *  );
     * });
     *
     * Register the application services.
     */
    public function register(): void
    {

    }
}
