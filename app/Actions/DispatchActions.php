<?php
/**
 * Create: Volodymyr
 */

namespace App\Actions;

use App\Actions\Task\TaskActions;
use App\Enums\DispatchStatusEnum;
use App\Enums\TaskStateEnum;
use App\Helpers\Value\ValueResponse;
use App\Models\Dispatch;
use App\Models\DispatchHistory;
use App\Models\Gateway;
use App\TDO\ClientVaultDTO;
use Illuminate\Database\Eloquent\Collection;
use App\Notifications\TaskOngageNotification;
use Illuminate\Support\Facades\Notification;
use NotificationChannels\OngageNotify\Contact\OngageContactMessageDTO;
use NotificationChannels\OngageNotify\DTO\OngageApiSettingsDTO;
use NotificationChannels\OngageNotify\Exceptions\CouldNotSendNotification;

class DispatchActions
{

    public static function sendNear(): void
    {
        /**
         * @var $dispatch Dispatch
         * @var $gateway Gateway
         */
        $items = static::getNeedToSend();
        foreach ($items as $dispatch) {
            static::send($dispatch);
        }

    }

    public static function getNeedToSend(): Collection
    {
        return Dispatch::query()
            ->with('task', 'gateway')
            ->whereBetween('send_date', [
                now()->subHours(5),
                now()
            ])
            ->where('send_status', DispatchStatusEnum::Create->value)
            ->get();
    }

    public static function send(Dispatch $dispatch): Dispatch
    {
        /**
         * @var $gateway Gateway
         * @var $dispatch_data ClientVaultDTO
         */
        $gateway = $dispatch->gateway;
        $dispatch_data = $dispatch->data;

        $settings = (new OngageApiSettingsDTO());

        if (!empty($gateway->settings['login'])) {
            $settings->setLogin($gateway->settings['login']);
        }
        if (!empty($gateway->settings['password'])) {
            $settings->setPassword($gateway->settings['password']);
        }
        if (!empty($gateway->settings['account_code'])) {
            $settings->setAccountCode($gateway->settings['account_code']);
        }
        if (!empty($gateway->settings['list_id'])) {
            $settings->setListId($gateway->settings['list_id']);
        }

        $message = (new OngageContactMessageDTO())
            ->setOverwrite($dispatch->settings?->getOverwrite())
            ->setFields($dispatch_data->toArray());

        $dispatch->send_status = DispatchStatusEnum::Sent->value;
        $dispatch->save();

        $status = true;

        try {
            Notification::sendNow($message, (new TaskOngageNotification($settings)));
        } catch (\Exception $e) {
            /**
             * @var $e CouldNotSendNotification
             */
            DispatchHistory::create([
                'dispatch_id' => $dispatch->id,
                'key' => 'Notification/send/error',
                'value' => json_encode(
                    (new ValueResponse($e->getResponse()))
                        ->setHeadersProtected(['X_USERNAME', 'X_PASSWORD', 'X_ACCOUNT_CODE'])
                        ->information(),
                    JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_INVALID_UTF8_IGNORE | JSON_UNESCAPED_UNICODE),
            ]);
            $dispatch->send_status = DispatchStatusEnum::Error->value;
            $dispatch->save();
            $status = false;
        }

        TaskActions::changeState(
            $dispatch->task,
            $dispatch->task->jobs_finish_at === $dispatch->send_date ? TaskStateEnum::FINISHED : TaskStateEnum::PROGRESS,
            $status
        );

        return $dispatch;
    }

}
