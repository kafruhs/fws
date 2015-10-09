<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 08.06.2015
 * Time: 07:40
 */

class NavigationEntry extends BaseObject
{
    /**
     * @var string
     */
    protected $table = "navigationEntry";

    protected $readPermission = Permission::BENUTZER;

    protected $writePermission = Permission::ADMINISTRATOR;

    protected $deletePermission = Permission::ADMINISTRATOR;

    protected $stdSearchColumns = ['name', 'url', 'category'];

    public function getDisplayName()
    {
        return "Navigationseinträge";
    }


}