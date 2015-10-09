<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.08.2014
 * Time: 08:09
 */

interface base_database_interface_GetStatement
{
    /**
     * generate sql string
     *
     * @return string
     */
    public function toString();

    /**
     * fetch result from database
     *
     * @return array
     */
    public function fetchDatabase();
} 