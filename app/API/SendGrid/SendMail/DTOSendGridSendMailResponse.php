<?php
namespace App\API\SendGrid\SendMail;

use App\API\Common\Interfaces\ResponseInterface;
use App\API\Common\Traits\DTOHelps;

class DTOSendGridSendMailResponse implements ResponseInterface
{
    use DTOHelps;

    protected ?string $message_id = null;

    public function getMessageId(): ?string
    {
        return $this->message_id;
    }

    public function setMessageId(?string $message_id): static
    {
        $this->message_id = $message_id;
        return $this;
    }
}
