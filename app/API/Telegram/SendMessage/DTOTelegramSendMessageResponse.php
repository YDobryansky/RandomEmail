<?php
/**
 * Create: Volodymyr
 */

namespace App\API\Telegram\SendMessage;

use App\API\Common\Interfaces\ResponseInterface;
use App\API\Common\Traits\DTOHelps;
use App\API\Telegram\Types\DTOTelegramMessage;

class DTOTelegramSendMessageResponse extends DTOTelegramMessage implements ResponseInterface
{
    use DTOHelps;
}
