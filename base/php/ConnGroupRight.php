<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 24.05.2015
 * Time: 13:21
 */

class ConnGroupRight extends BaseConnectionObject
{
    const CLASS_GROUP = 'Group';

    const CLASS_RIGHT = 'Permission';

    protected $table = 'group$right';

    protected $classLeft = self::CLASS_GROUP;

    protected $classRight = self::CLASS_RIGHT;
}