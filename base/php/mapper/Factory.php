<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 29.01.2015
 * Time: 11:21
 */

class base_mapper_Factory
{
    /**
     * create a mapper object or return null
     *
     * @param BaseObject $obj
     * @param $fieldName
     * @return base_mapper_BaseObject|null
     */
    public static function createObject($class, $fieldName)
    {
        foreach (base_infrastructure_Folder::getFilesFromFolder('modules') as $module) {
            $className = "{$module}_mapper_" . strtolower($class) . "_" . ucfirst(str_replace('_', '', $fieldName));
            try {
                if (class_exists($className)) {
                    return new $className();
                }
            } catch (Exception $e) {
            }
        }
        return null;
    }
}