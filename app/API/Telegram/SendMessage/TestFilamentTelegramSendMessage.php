<?php
/**
 * Create: Volodymyr
 */

namespace App\API\Telegram\SendMessage;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class TestFilamentTelegramSendMessage
{
    public static function make($settings_key = 'settings'): Section
    {

        return Section::make('Sending Telegram Test message')
            ->columnSpanFull()
            ->collapsed()
            ->headerActions([
                Action::make('Test')
                    ->form([
                        TextInput::make('text')
                            ->default('Send test message ' . date('Y-m-d H:i:s'))
                    ])
                    ->action(function (array $data, Model $record) use ($settings_key) {
                        try {
                            $result = ServiceTelegramSendMessage::send(
                                ServiceTelegramSendMessage::settings($record->getAttribute($settings_key)),
                                ServiceTelegramSendMessage::request($data),
                            );
                            Notification::make()
                                ->title('Telegram Test Message')
                                ->body('Ok ' . $result->getMessageId())
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            debug($e);
                            Notification::make()
                                ->title('Telegram Test Message')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }

                    }),
            ]);

    }
}
