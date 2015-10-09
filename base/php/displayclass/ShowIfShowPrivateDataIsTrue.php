<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.01.2015
 * Time: 07:19
 */

class base_displayClass_ShowIfShowPrivateDataIsTrue extends DisplayClass
{

    /**
     * get the displayMode for the actual field in scope
     *
     * @param $displayMode string
     * @return string
     */
    public function getDisplayMode($displayMode)
    {
        if (isset($this->obj['showPrivateData']) && $this->obj['showPrivateData'] === false) {
            return DisplayClass::HIDE;
        }
        return $displayMode;
    }
}