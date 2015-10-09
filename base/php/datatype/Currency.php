<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09.10.2014
 * Time: 07:11
 */

class base_datatype_Currency extends base_datatype_Float
{
    public function getJSColModelElement()
    {
        $colModel = parent::getJSColModelElement();
        $colModel->setFormatter(base_js_ColModelElement::FORMATTER_CURRENCY)
            ->setAlign(base_js_ColModelElement::ALIGN_RIGHT);
        return $colModel;
    }
} 