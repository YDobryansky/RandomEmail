<?php
/**
 * Create: Volodymyr
 */

namespace App\Actions\Api;

use App\API\Common\Exceptions\APIException;
use App\API\Common\Interfaces\ResponseInterface;
use App\API\Common\Interfaces\ServiceInterface;
use App\Models\Api;

class ApiActions
{
    /**
     * @throws APIException
     */
    public static function send(Api $api, array $data): ResponseInterface
    {
        /**
         * @var ServiceInterface $driver
         */
        $driver = $api->driver;

        return $driver::send(
            $driver::settings($api->settings),
            $driver::request($data)
        );
    }

    public static function requestArgs(Api $api): array
    {
        /**
         * @var ServiceInterface $driver
         */
        $driver = $api->driver;

        return array_keys($driver::request($driver::settings($api->settings)->toArray())
            ->emptyRequiredArgs());
    }

    public static function responseArgs(Api $api): array
    {
        /**
         * @var ServiceInterface $driver
         */
        $driver = $api->driver;

        return $driver::response([])->keys();
    }

    public static function getKey(Api $api): string
    {
//        return ToolItem::RESULT;
        /**
         * @var ServiceInterface $driver
         */
        return $api->driver::getKey();
    }
}
