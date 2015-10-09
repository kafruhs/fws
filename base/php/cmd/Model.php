<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.02.2015
 * Time: 07:31
 */

abstract class base_cmd_Model
{
    /**
     * @var array
     */
    protected $cmds = [];

    /**
     * @var bool
     */
    protected $usePassthru = true;

    /**
     * @return mixed
     */
    public function execute()
    {

    }

    abstract public function getHelp();
}