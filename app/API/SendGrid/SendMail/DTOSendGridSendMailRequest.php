<?php
namespace App\API\SendGrid\SendMail;

use App\API\Common\Interfaces\RequestInterface;
use App\API\Common\Traits\DTOHelps;

class DTOSendGridSendMailRequest implements RequestInterface
{
    use DTOHelps;

    protected ?string $from_email = null;
    protected ?string $from_name = null;
    protected ?string $to_email = null;
    protected ?string $to_name = null;
    protected ?string $subject = null;
    protected ?string $text = null;

    public function emptyRequiredArgs(): array
    {
        return array_filter([
            'from_email' => empty($this->from_email),
            'to_email' => empty($this->to_email),
            'subject' => empty($this->subject),
            'text' => empty($this->text),
        ]);
    }

    public function isEmptyRequiredArgs(): bool
    {
        return !empty($this->emptyRequiredArgs());
    }

    public function getFromEmail(): ?string
    {
        return $this->from_email;
    }

    public function setFromEmail(?string $from_email): static
    {
        $this->from_email = $from_email;
        return $this;
    }

    public function getFromName(): ?string
    {
        return $this->from_name;
    }

    public function setFromName(?string $from_name): static
    {
        $this->from_name = $from_name;
        return $this;
    }

    public function getToEmail(): ?string
    {
        return $this->to_email;
    }

    public function setToEmail(?string $to_email): static
    {
        $this->to_email = $to_email;
        return $this;
    }

    public function getToName(): ?string
    {
        return $this->to_name;
    }

    public function setToName(?string $to_name): static
    {
        $this->to_name = $to_name;
        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): static
    {
        $this->subject = $subject;
        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;
        return $this;
    }
}
