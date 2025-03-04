<?php
/**
 * Create: Volodymyr
 */

namespace App\API\Telegram\SendMessage;

use App\API\Common\Interfaces\RequestInterface;
use App\API\Common\Traits\DTOHelps;

class DTOTelegramSendMessageRequest implements RequestInterface
{
    use DTOHelps;
    protected ?string $business_connection_id = null;
    protected ?string $chat_id = null;
    protected ?int $message_thread_id = null;
    protected ?string $text = null;
    protected ?string $parse_mode = null;
    protected array|object|null $entities = null;
    protected array|object|null $link_preview_options = null;
    protected ?bool $disable_notification = null;
    protected ?bool $protect_content = null;
    protected ?string $message_effect_id = null;
    protected array|object|null $reply_parameters = null;
    protected array|object|null $reply_markup = null;


    public function emptyRequiredArgs(): array
    {
        return array_filter([
            'chat_id' => empty($this->chat_id),
            'text' => empty($this->text),
        ]);
    }

    public function isEmptyRequiredArgs(): bool
    {
        return !empty($this->emptyRequiredArgs());
    }

    public function getBusinessConnectionId(): ?string
    {
        return $this->business_connection_id;
    }

    public function setBusinessConnectionId(?string $business_connection_id): static
    {
        $this->business_connection_id = $business_connection_id;
        return $this;
    }

    public function getChatId(): ?string
    {
        return $this->chat_id;
    }

    public function setChatId(?string $chat_id): static
    {
        $this->chat_id = $chat_id;
        return $this;
    }

    public function getMessageThreadId(): ?int
    {
        return $this->message_thread_id;
    }

    public function setMessageThreadId(?int $message_thread_id): static
    {
        $this->message_thread_id = $message_thread_id;
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

    public function getParseMode(): ?string
    {
        return $this->parse_mode;
    }

    public function setParseMode(?string $parse_mode): static
    {
        $this->parse_mode = $parse_mode;
        return $this;
    }

    public function getEntities(): object|array|null
    {
        return $this->entities;
    }

    public function setEntities(object|array|null $entities): static
    {
        $this->entities = $entities;
        return $this;
    }

    public function getLinkPreviewOptions(): object|array|null
    {
        return $this->link_preview_options;
    }

    public function setLinkPreviewOptions(object|array|null $link_preview_options): static
    {
        $this->link_preview_options = $link_preview_options;
        return $this;
    }

    public function getDisableNotification(): ?bool
    {
        return $this->disable_notification;
    }

    public function setDisableNotification(?bool $disable_notification): static
    {
        $this->disable_notification = $disable_notification;
        return $this;
    }

    public function getProtectContent(): ?bool
    {
        return $this->protect_content;
    }

    public function setProtectContent(?bool $protect_content): static
    {
        $this->protect_content = $protect_content;
        return $this;
    }

    public function getMessageEffectId(): ?string
    {
        return $this->message_effect_id;
    }

    public function setMessageEffectId(?string $message_effect_id): static
    {
        $this->message_effect_id = $message_effect_id;
        return $this;
    }

    public function getReplyParameters(): object|array|null
    {
        return $this->reply_parameters;
    }

    public function setReplyParameters(object|array|null $reply_parameters): static
    {
        $this->reply_parameters = $reply_parameters;
        return $this;
    }

    public function getReplyMarkup(): object|array|null
    {
        return $this->reply_markup;
    }

    public function setReplyMarkup(object|array|null $reply_markup): static
    {
        $this->reply_markup = $reply_markup;
        return $this;
    }

}
