<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 26.01.2015
 * Time: 12:55
 */

class TSMNode extends BaseObject
{
    protected $table = 'tsmnode';

    protected $colNamesForImport = array(
        'name',
        'tcpAddress',
        'tcpName',
        'regTime',
        'regAdmin',
        'FK_collocgroup',
        'FK_domain',
        'lastAccessTime',
        'lastCommMeth',
        'lastCommWait',
        'lastDuration',
        'lastIdleWait',
        'lastMediaWait',
        'lastReceived',
        'lastSent'
    );

    protected $stdSearchColumns = array('name', 'tcpName', 'FK_collocgroup', 'FK_domain', 'FK_tsmserver');
}