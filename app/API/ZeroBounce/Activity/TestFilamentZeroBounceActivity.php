<?php
/**
 * Create: Volodymyr
 */

namespace App\API\ZeroBounce\Activity;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class TestFilamentZeroBounceActivity
{
    public static function make($settings_key = 'settings'): Section
    {

        return Section::make('Sending Test Request')
            ->icon('heroicon-o-arrow-top-right-on-square')
            ->columnSpanFull()
            ->collapsed()
            ->headerActions([
                Action::make('Sending Test Request')
                    ->label('Send')
                    ->form([
                        TextInput::make('email')
                            ->default(fake()->email())
                    ])
                    ->action(function (array $data, Model $record) use ($settings_key) {
                        try {
                            $result = ServiceZeroBounceActivity::send(
                                ServiceZeroBounceActivity::settings($record->getAttribute($settings_key)),
                                ServiceZeroBounceActivity::request($data),
                            );

                            debug($result);

                            Notification::make()
                                ->title('All good')
                                ->body('Ok ' . json_encode($result->toArray()))
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            debug($e->getPrevious());
                            Notification::make()
                                ->title('Error')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }

                    }),
            ]);

    }
}
