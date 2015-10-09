<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.06.2015
 * Time: 09:59
 */

class base_datapermission_Factory
{
    /**
     * get a new instance of the given className
     *
     * @param $className
     * @return BaseObject
     * @throws BaseException
     */
    public static function createObject($className, BaseObject $obj)
    {
        Check::className($className);
        $dPObj = new $className($obj);
        if (!$dPObj instanceof DataPermission) {
            throw new base_exception_DataPermission(TMS(base_exception_DataPermission::FACTORY_NO_INSTANCE_OF_DP));
        }
        return $dPObj;
    }
}