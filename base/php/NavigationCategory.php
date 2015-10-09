<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 08.06.2015
 * Time: 07:40
 */

class NavigationCategory extends BaseObject
{
    /**
     * @var string
     */
    protected $table = "navigationCategory";

    protected $stdSearchColumns = array('LK', 'name', 'sort');

    public function getDisplayName()
    {
        return "Navigationskategorie";
    }


}