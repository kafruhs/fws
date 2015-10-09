<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.01.2015
 * Time: 13:30
 */

class base_form_element_Numeric extends base_form_element_Alphanumeric
{
    protected $size = 5;

    protected function addClass()
    {
        $this->class .= ' numeric';
    }
}