<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.08.2014
 * Time: 08:18
 */

interface base_database_interface_Term
{
    /**
     * prepare output string
     *
     * @return string
     */
    public function toString();

    public function setValue($value);
} 