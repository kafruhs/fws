<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02.06.2015
 * Time: 07:15
 */

class base_displayclass_AdminOnly extends DisplayClass
{

    /**
     * get the displayMode for the actual field in scope
     *
     * @param $displayMode string
     * @return string
     */
    public function getDisplayMode($displayMode)
    {
        $user = Flat::user();
        if (!$user->isEntitled('Administrator')) {
            return DisplayClass::VIEW;
        } else {
            return $displayMode;
        }

    }
}