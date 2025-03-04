<?php
/**
 * Create: Vladimir
 */
namespace NotificationChannels\AbstractDriver\Enums;

class EnumAbstractChannelStatus
{
    const UNKNOWN = 0;


    protected static array $extend = [];

    /**
     * @throws \ReflectionException
     */
    public static function data(): array
    {
        static $constants = [];
        $class_name = static::class;
        if (isset($constants[$class_name])) {
            return $constants[$class_name];
        }

        $ref = new \ReflectionClass($class_name);
        $class_constants = $ref->getConstants();// \ReflectionClassConstant::IS_PUBLIC

        $data = [];
        foreach ($class_constants as $name => $id) {
            $data[] = (static::$extend[$id] ?? []) + [
                    'id' => $id,
                    'key' => $name,
                    'name' => $name,
                ];
        }

        $constants[$class_name] = $data;

        return $constants[$class_name];
    }

    /**
     * @throws \ReflectionException
     */
    public static function getByKey($value): ?array
    {
        return static::getBy($value, 'key');
    }

    /**
     * @throws \ReflectionException
     */
    public static function getBy($value, $key)
    {
        $data = static::data();

        $items = array_filter($data, function ($item) use ($key, $value) {
            return $item[$key] === $value;
        });

        return array_shift($items);
    }
}
