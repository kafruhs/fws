<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.08.2014
 * Time: 08:09
 */

interface base_database_interface_SetStatement
{
    /**
     * generate sql string
     *
     * @return string
     */
    public function toString();

    /**
     * insert result into database
     *
     * @return int
     */
    public function insertDatabase();
} 