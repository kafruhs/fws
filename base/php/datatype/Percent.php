<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09.10.2014
 * Time: 07:11
 */

class base_datatype_Percent extends Datatype
{
    public function toInternalValue($value)
    {
        return (int) $value;
    }

    public function toExternal($value)
    {
        return (int) $value;
    }

    protected function validateValue($value)
    {
        if ($value > 100 || $value < 0) {
            throw new base_exception_Validation(TMS(base_exception_Validation::WRONG_PERCENT_VALUE));
        }
    }

    public function getJSColModelElement()
    {
        $colModel = parent::getJSColModelElement();
        $colModel->setFormatter(base_js_ColModelElement::FORMATTER_INTEGER)
            ->setAlign(base_js_ColModelElement::ALIGN_RIGHT);
        return $colModel;
    }
} 