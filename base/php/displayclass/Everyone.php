<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 16.12.2014
 * Time: 15:42
 */

class base_displayclass_Everyone extends DisplayClass
{

    /**
     * get the displayMode for the actual field in scope
     *
     * @param $displayMode string
     * @return string
     */
    public function getDisplayMode($displayMode)
    {
        return $displayMode;
    }
}