<?php

namespace App\TDO;

use App\Helpers\Store\AbstractDTO;

/**
 * @method string getEmail()
 * @method string getAddress()
 * @method string getCountry()
 * @method string getFirstName()
 * @method string getLastName()
 * @method string getGender()
 * @method string getLanguage()
 * @method string getPhone()
 * @method string getCompany()
 * @method string getPosition()
 * @method string getCity()
 * @method string getState()
 * @method string getZip()
 * @method string getBirthdate()
 *
 * @method static setEmail($value)
 * @method static setAddress($value)
 * @method static setCountry($value)
 * @method static setFirstName($value)
 * @method static setLastName($value)
 * @method static setGender($value)
 * @method static setLanguage($value)
 * @method static setPhone($value)
 * @method static setCompany($value)
 * @method static setPosition($value)
 * @method static setCity($value)
 * @method static setState($value)
 * @method static setZip($value)
 * @method static setBirthdate($value)
 *
 */
class ClientVaultDTO extends AbstractDTO
{

    public static function keys(): ?array
    {
        return null;
    }

    public static function defaultKeys(): array
    {
        return [
            'email',
            'country',
            'first_name',
            'last_name',
            'phone',
            'marketingchannel',
            'afi',
            'leadsource',
            'scode',
            'd_family',
        ];
    }

}
