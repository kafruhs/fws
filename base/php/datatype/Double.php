<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 05.02.2015
 * Time: 15:23
 */

class base_datatype_Double extends Datatype
{
    protected function toInternalValue($value)
    {
        return parent::toInternalValue($value); // TODO: Change the autogenerated stub
    }

    public function toExternal($value)
    {
        return parent::toExternal($value); // TODO: Change the autogenerated stub
    }

    protected function validateValue($value)
    {
        return parent::validateValue($value); // TODO: Change the autogenerated stub
    }

    public function getJSColModelElement()
    {
        $colModel = parent::getJSColModelElement();
        $colModel->setFormatter(base_js_ColModelElement::FORMATTER_NUMBER);
        return $colModel;
    }

}