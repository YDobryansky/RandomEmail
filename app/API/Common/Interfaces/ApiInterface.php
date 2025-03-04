<?php
/**
 * Create: Volodymyr
 */

namespace App\API\Common\Interfaces;

interface ApiInterface
{

    public static function send(SettingsInterface $settings, RequestInterface $request): ResponseInterface;
    public function __construct(SettingsInterface $settings);

    public function request(RequestInterface $request): static;

    public function response(): ResponseInterface;

    public function getResponse(): mixed;
}
