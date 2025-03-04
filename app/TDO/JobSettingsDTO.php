<?php
/**
 * Create: Volodymyr
 */

namespace App\TDO;

use App\Helpers\Store\AbstractDTO;

/**
 * Class JobSettingsDTO
 *
 * @method string|null getOverwrite()
 * @method self setOverwrite(string $rewrite)
 */
class JobSettingsDTO extends AbstractDTO
{
    public static function keys(): ?array
    {
        return [
            'overwrite'
        ];
    }
}
