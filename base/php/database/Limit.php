<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.09.2014
 * Time: 14:37
 */

class base_database_Limit
{
    /**
     * @var int
     */
    protected $offset = 0;

    /**
     * @var int
     */
    protected $limit;

    /**
     * set a limit
     *
     * @param $limit
     */
    public function __construct($limit)
    {
        $this->setLimit($limit);
    }

    /**
     * set the number of datasets that should be found
     *
     * @param $limit
     * @throws base_database_Exception
     */
    public function setLimit($limit)
    {
        $this->_isInt($limit);
        $this->limit = $limit;
    }

    /**
     * set the starting index
     *
     * @param $offset
     * @throws base_database_Exception
     */
    public function setOffset($offset)
    {
        $this->_isInt($offset);
        $this->offset = $offset;
    }

    /**
     *
     *
     * @return string
     */
    public function toString()
    {
        return $this->offset . ', ' . $this->limit;
    }

    /**
     * check the value to be int
     *
     * @param $integer
     * @throws base_database_Exception
     */
    private function _isInt($integer)
    {
        if (is_int($integer) === false) {
            throw new base_database_Exception(TMS(base_database_Exception::NO_INT_VALUE, array('value' => $integer)));
        }
    }
} 