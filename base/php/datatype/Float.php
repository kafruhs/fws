<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09.10.2014
 * Time: 07:11
 */

class base_datatype_Float extends Datatype
{
    public function toInternalValue($value)
    {
        if (is_float($value)) {
            return $value;
        }

        $floatParts = explode(',', $value);
        if (count($floatParts) == 1) {
            return $floatParts[0] . '.00';
        }
        if (count($floatParts) != 2 && !is_int($floatParts[0]) && !is_int($floatParts[1])) {
            throw new base_exception_Validation(TMS(base_exception_Validation::WRONG_FLOAT_FORMAT));
        }

        $value = $floatParts[0] . '.' . $floatParts[1];

        return $value;
    }

    public function toExternal($value)
    {
        return number_format($value, 2, ',', '.');
    }


    public function getJSColModelElement()
    {
        $colModel = parent::getJSColModelElement();
        $colModel->setFormatter(base_js_ColModelElement::FORMATTER_NUMBER)
            ->setAlign(base_js_ColModelElement::ALIGN_RIGHT);
        return $colModel;
    }

    public function fromDB($value)
    {
        return $value; // TODO: Change the autogenerated stub
    }


} 