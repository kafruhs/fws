<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 24.08.2014
 * Time: 16:08
 */

class base_database_Order
{
    const ASC = 'asc';

    const DESC = 'desc';

    /**
     * @var string
     */
    protected $orderString;

    public function __construct(base_database_Column $column, $direction = self::DESC)
    {
        $this->_validateDirection($direction);
        $this->orderString = $column->getName() . " $direction";
    }

    /**
     * get the order string
     *
     * @return string
     */
    public function toString()
    {
        return $this->orderString;
    }

    /**
     * validate the give direction
     *
     * @param $direction
     * @throws base_database_Exception
     */
    private function _validateDirection($direction)
    {
        if (in_array($direction, [self::ASC, self::DESC]) === false) {
            throw new base_database_Exception(TMS(base_database_Exception::NO_VALID_ORDER_DIRECTION, array('direction' => $direction)));
        }
    }
} 