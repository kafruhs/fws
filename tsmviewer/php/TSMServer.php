<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 21.01.2015
 * Time: 14:31
 */

class TSMServer extends BaseObject
{
    protected $table = 'tsmserver';

    protected $stdSearchColumns = array('name', 'dns', 'port');

    public function getDisplayName()
    {
        return 'TSM Server Instanzen';
    }
}