<?php
/**
 * Create: Volodymyr
 */

namespace App\API\Telegram\SendMessage;

use App\API\Common\Interfaces\SettingsInterface;
use App\API\Common\Traits\DTOHelps;
use Filament\Forms\Components\TextInput;

class DTOTelegramSendMessageSettings implements SettingsInterface
{
    use DTOHelps;

    protected string $path = '/sendMessage';
    protected string $domain = 'https://api.telegram.org/bot';

    protected ?string $bot_id = null;
    protected ?string $chat_id = null;
    protected ?int $message_thread_id = null;

    public function __construct()
    {
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;
        return $this;
    }

    public function url(): string
    {
        return $this->getDomain() . $this->getBotId() . $this->getPath();
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): static
    {
        $this->domain = $domain;
        return $this;
    }

    public function getBotId(): ?string
    {
        return $this->bot_id;
    }

    public function setBotId(?string $bot_id): static
    {
        $this->bot_id = $bot_id;
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


    public static function form(string $block_key = 'settings'): array
    {
        return [
            TextInput::make($block_key . '.bot_id')
                ->required(),
            TextInput::make($block_key . '.chat_id')
                ->required(),
            TextInput::make($block_key . '.message_thread_id')
                ->label('Topic ID (message_thread_id)'),
            TestFilamentTelegramSendMessage::make($block_key)
        ];
    }

}
