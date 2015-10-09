<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 15.01.2015
 * Time: 07:45
 */

class base_datatype_Text extends base_datatype_Alphanumeric
{
    public function getEmptyValue()
    {
        return '';
    }

    protected function toInternalValue($value)
    {
        return nl2br($value);
    }
}