<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 06.02.2015
 * Time: 13:00
 */

class TSMSummary extends TSMObject
{
    protected $table = 'tsmsummary';

    protected $colNamesForImport = array(
        'nodeName',
        'subEntity',
        'successful',
        'bytes',
        'examined',
        'affected',
        'startTime',
        'failed'
    );

    protected $stdSearchColumns = array(
        'nodeName',
        'subEntity',
        'successful',
        'startTime',
        'failed',
        'FK_tsmserver'
    );


}