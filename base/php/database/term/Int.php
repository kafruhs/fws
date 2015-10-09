<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.08.2014
 * Time: 08:14
 */

class base_database_term_Int implements base_database_interface_Term
{
    /**
     * @var int
     */
    protected $int;

    /**
     * set a new int value
     *
     * @param int $value
     * @throws base_database_Exception
     */
    public function setValue($value)
    {
        if (is_int($value) === false) {
            throw new base_database_Exception(TMS(base_database_Exception::NO_INT_VALUE, array('value' => $value)));
        }
        $this->int = $value;
    }

    /**
     * prepare output string
     *
     * @return string
     */
    public function toString()
    {
        return $this->int;
    }
}