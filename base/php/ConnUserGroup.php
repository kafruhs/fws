<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 24.05.2015
 * Time: 13:21
 */

class ConnUserGroup extends BaseConnectionObject
{
    const CLASS_GROUP = 'Group';

    const CLASS_USER = 'User';

    protected $table = 'user$group';

    protected $classLeft = self::CLASS_USER;

    protected $classRight = self::CLASS_GROUP;

}