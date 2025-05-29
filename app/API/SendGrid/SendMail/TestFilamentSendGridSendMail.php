<?php
namespace App\API\SendGrid\SendMail;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class TestFilamentSendGridSendMail
{
    public static function make(string $settings_key = 'settings'): Section
    {
        return Section::make('SendGrid Test Mail')
            ->icon('heroicon-o-arrow-top-right-on-square')
            ->columnSpanFull()
            ->collapsed()
            ->headerActions([
                Action::make('Send')
                    ->form([
                        TextInput::make('to_email')
                            ->required(),
                        TextInput::make('subject')
                            ->required(),
                        TextInput::make('text')
                            ->required(),
                        TextInput::make('from_email')
                            ->default('noreply@example.com'),
                    ])
                    ->action(function (array $data, Model $record) use ($settings_key) {
                        try {
                            $result = ServiceSendGridSendMail::send(
                                ServiceSendGridSendMail::settings($record->getAttribute($settings_key)),
                                ServiceSendGridSendMail::request($data)
                            );

                            Notification::make()
                                ->title('SendGrid Test Mail')
                                ->body('Ok ' . $result->getMessageId())
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('SendGrid Test Mail')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
            ]);
    }
}
