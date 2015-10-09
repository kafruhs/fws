<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.09.2014
 * Time: 14:56
 */

class Factory
{
    /**
     * get a new instance of the given className
     *
     * @param $className
     * @return BaseObject
     * @throws BaseException
     */
    public static function createObject($className)
    {
        Check::className($className);
        return new $className();
    }

    /**
     * load a BaseObject with the given key
     *
     * @param $className
     * @param $key
     * @param int $loadMode
     * @return BaseObject
     */
    public static function loadObject($className, $key, $loadMode = BaseObject::LOAD_LK)
    {
        $obj = self::createObject($className);
        return $obj->load($key, $loadMode);
    }
} 