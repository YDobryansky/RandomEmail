<?php

namespace App\Filament\Pages;

use App\Enums\GatewayTypeEnum;
use App\Models\Gateway;
use Filament\Pages\Page;
use NotificationChannels\OngageNotify\DTO\OngageApiSettingsDTO;
use NotificationChannels\OngageNotify\OngageApi;

class ContactHistory extends Page
{
    protected static bool $shouldRegisterNavigation = false;
    protected static string $view = 'filament.pages.contact-history';

    public ?int $gatewayId = null;
    public string|int $contactId;
    public array $history = [];

    public function mount(int $contactId, int $gatewayId): void
    {
        $this->contactId = $contactId;
        $this->gatewayId = $gatewayId;

        $gateway = Gateway::find($gatewayId);
        if (! $gateway || $gateway->type !== GatewayTypeEnum::Ongage->value) {
            return;
        }

        $settings = $gateway->settings;
        $dto = (new OngageApiSettingsDTO())
            ->setBaseUrl($settings['url'] ?? '')
            ->setLogin($settings['login'] ?? '')
            ->setPassword($settings['password'] ?? '')
            ->setAccountCode($settings['account_code'] ?? '')
            ->setListId($settings['list_id'] ?? '');

        $api = (new OngageApi())->setSettings($dto);
        $this->history = $api->getContactHistory($contactId);
    }

    protected function getViewData(): array
    {
        return [
            'history' => $this->history,
            'contact' => $this->contactId,
        ];
    }
}
