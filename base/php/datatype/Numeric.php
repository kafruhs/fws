<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09.10.2014
 * Time: 07:11
 */

class base_datatype_Numeric extends Datatype
{
    public function toInternalValue($value)
    {
        return (int) $value;
    }

    public function toExternal($value)
    {
        return (int) $value;
    }


    public function getJSColModelElement()
    {
        $colModel = parent::getJSColModelElement();
        $colModel->setFormatter(base_js_ColModelElement::FORMATTER_INTEGER)
            ->setAlign(base_js_ColModelElement::ALIGN_RIGHT);
        return $colModel;
    }
} 