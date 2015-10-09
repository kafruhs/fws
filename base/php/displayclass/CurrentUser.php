<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.01.2015
 * Time: 07:24
 */

class base_displayClass_CurrentUser extends DisplayClass
{

    /**
     * get the displayMode for the actual field in scope
     *
     * @param $displayMode string
     * @return string
     */
    public function getDisplayMode($displayMode)
    {
        if (is_null(Flat::user())) {
            return DisplayClass::HIDE;
        }
        return $displayMode;
    }
}