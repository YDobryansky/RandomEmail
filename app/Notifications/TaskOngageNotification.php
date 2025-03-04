<?php

namespace App\Notifications;

use App\TDO\ClientDTO;
use App\TDO\ClientVaultDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\OngageNotify\Contact\OngageContactMessage;
use NotificationChannels\OngageNotify\Contact\OngageContactMessageDTO;
use NotificationChannels\OngageNotify\DTO\OngageApiSettingsDTO;
use NotificationChannels\OngageNotify\OngageServiceProvider;

class TaskOngageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected OngageApiSettingsDTO $api_settings;

    protected OngageContactMessageDTO $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(?OngageApiSettingsDTO $api_settings = null)
    {
        $this->setApiSettings($api_settings ?? new OngageApiSettingsDTO());
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [OngageServiceProvider::DRIVER_CONTACT];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param OngageContactMessageDTO|object $notifiable
     * @return OngageContactMessage
     */
    public function toOngageContact(object $notifiable): OngageContactMessage
    {
        $this->setMessage($notifiable);

        return (new OngageContactMessage())
            ->setSettings($this->getApiSettings())
            ->setMessage($this->getMessage());

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function getApiSettings(): OngageApiSettingsDTO
    {
        return $this->api_settings;
    }

    public function setApiSettings(OngageApiSettingsDTO $api_settings): static
    {
        $this->api_settings = $api_settings;
        return $this;
    }

    public function getMessage(): OngageContactMessageDTO
    {
        return $this->message;
    }

    public function setMessage(OngageContactMessageDTO $message): static
    {
        $this->message = $message;
        return $this;
    }

}
