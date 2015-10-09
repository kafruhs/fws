<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.08.2014
 * Time: 08:28
 */

class base_database_term_String implements base_database_interface_Term
{
    /**
     * @var string
     */
    protected $string;

    /**
     * prepare output string
     *
     * @return string
     */
    public function toString()
    {
        return "'{$this->string}'";
    }

    public function setValue($value)
    {
        if (is_object($value) === true || is_array($value) === true || is_int($value)) {
            throw new base_database_Exception(base_database_Exception::NO_STRING_VALUE);
        }

        $this->string = $value;
    }
}