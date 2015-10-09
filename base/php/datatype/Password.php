<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.01.2015
 * Time: 07:22
 */

class base_datatype_Password extends Datatype
{
    protected function toInternalValue($value)
    {
        return md5($value);
    }

    public function fromDB($value)
    {
        return $value;
    }


}