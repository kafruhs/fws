<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.09.2014
 * Time: 14:57
 */

class Check
{
    public static function className($className)
    {
        if (class_exists($className) === false) {
            throw new BaseException(TMS(BaseException::CLASS_NOT_EXISTS, array('class' => $className)));
        }
    }

    public static function classNameInstanceOfBaseObject($className)
    {
        $obj = Factory::createObject($className);
        if ($obj instanceof BaseObject === false) {
            throw new BaseException(TMS(BaseException::CLASS_NOT_INSTANCEOF_BASOBJECT, array('class' => $className)));
        }
    }

} 