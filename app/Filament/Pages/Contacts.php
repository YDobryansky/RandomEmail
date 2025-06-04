<?php

namespace App\Filament\Pages;

use App\Enums\GatewayTypeEnum;
use App\Models\Gateway;
use Filament\Pages\Page;
use NotificationChannels\OngageNotify\DTO\OngageApiSettingsDTO;
use NotificationChannels\OngageNotify\OngageApi;

class Contacts extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Planner';
    protected static ?string $title = 'Contacts';
    protected static ?int $navigationSort = 6;

    protected static string $view = 'filament.pages.contacts';

    public ?int $gatewayId = null;
    public array $contacts = [];
    public bool $loading = false;

    public function connect(): void
    {
        $this->reset('contacts');
        $this->loading = true;

        if (!$this->gatewayId) {
            $this->loading = false;
            return;
        }

        $gateway = Gateway::find($this->gatewayId);
        if (! $gateway || $gateway->type !== GatewayTypeEnum::Ongage->value) {
            $this->loading = false;
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

        $this->contacts = $api->listContacts();
        $this->loading = false;
    }

    public function viewContact(string|int $contactId): void
    {
        $this->redirect(ContactHistory::getUrl(['contactId' => $contactId, 'gatewayId' => $this->gatewayId]));
    }

    protected function getViewData(): array
    {
        return [
            'gateways' => Gateway::query()
                ->where('type', GatewayTypeEnum::Ongage->value)
                ->pluck('name', 'id')
                ->toArray(),
        ];
    }
}
