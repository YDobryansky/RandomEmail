<?php
/**
 * Create: Volodymyr
 */

namespace App\API\Common\Interfaces;

interface SettingsInterface
{
    public static function form(string $block_key = 'settings'): array;

}
