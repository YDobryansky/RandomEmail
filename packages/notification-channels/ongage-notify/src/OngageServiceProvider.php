<?php

namespace NotificationChannels\OngageNotify;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use NotificationChannels\OngageNotify\Contact\OngageContactChannel;
use NotificationChannels\OngageNotify\Validation\OngageValidationChannel;

class OngageServiceProvider extends ServiceProvider
{
    const CHANNEL = 'ongage-notify';
    const DRIVER_VALIDATION = 'ongage_validation';
    const DRIVER_CONTACT = 'ongage_contact';

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/' . self::CHANNEL . '.php', self::CHANNEL
        );

        Notification::resolved(static function (ChannelManager $service) {
            $service->extend(
                static::DRIVER_CONTACT,
                static fn ($app) => $app->make(OngageContactChannel::class)
            );
            $service->extend(
                static::DRIVER_VALIDATION,
                static fn ($app) => $app->make(OngageValidationChannel::class)
            );
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/' . self::CHANNEL . '.php' => config_path(self::CHANNEL . '.php'),
            ], 'config');
        }
    }

}
