<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.01.2015
 * Time: 07:12
 */

class base_form_element_Datetime extends base_form_element_Alphanumeric
{
    protected function addClass()
    {
        $this->class .= ' dateTime';
    }

}