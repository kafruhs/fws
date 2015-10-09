<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.01.2015
 * Time: 14:09
 */

class base_form_element_Factory
{
    /**
     * create a new base_form_element_...
     *
     * @param $datatype
     * @return base_form_Input
     */
    public static function createElement(Fieldinfo $fieldinfo)
    {
        $datatype = ucfirst($fieldinfo->getDataType());
        $customClassName = "Custom_form_element_$datatype";
        $baseClassName = "base_form_element_$datatype";
        if (file_exists(ROOT . "/Custom/php/form/element/$datatype.php")) {
            return new $customClassName($fieldinfo);
        }
        return new $baseClassName($fieldinfo);
    }
}