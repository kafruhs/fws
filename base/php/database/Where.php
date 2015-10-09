<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.08.2014
 * Time: 08:10
 */

class base_database_Where
{
    const EQUAL = '=';

    const GREATER = '>';

    const SMALLER = '<';

    const LIKE = 'like';

    /**
     * @var array
     */
    private $_conditions = [];

    /**
     * @var string
     */
    public $conditionString;

    public function __construct(base_database_Column $column, base_database_interface_Term $value, $op = self::EQUAL)
    {
        $this->_validateOperator($op);
        $condition = $column->getName() . " $op " . $value->toString();
        $this->conditionString = $condition;
        $this->_conditions['initial'] = $condition;
    }

    /**
     * add a new Condition and connect it to the other conditions via "AND"
     *
     * @param base_database_Column $column
     * @param base_database_interface_Term $value
     * @param string $op
     */
    public function addAnd(base_database_Column $column, base_database_interface_Term $value, $op = self::EQUAL)
    {
        $this->_validateOperator($op);
        $condition = $column->getName() . " $op " . $value->toString();
        $this->conditionString .= ' AND ' . $condition;
        $this->_conditions['and'][] = $condition;
    }

    /**
     * add a new Condition and connect it to the other conditions via "OR"
     *
     * @param base_database_Column $column
     * @param base_database_interface_Term $value
     * @param string $op
     */
    public function addOr(base_database_Column $column, base_database_interface_Term $value, $op = self::EQUAL)
    {
        $this->_validateOperator($op);
        $condition = $column->getName() . " $op " . $value->toString();
        $this->conditionString .= ' OR ' . $condition;
        $this->_conditions['or'][] = $condition;
    }

    /**
     * get the where term as string
     *
     * @return string
     */
    public function toString()
    {
        return $this->conditionString;
    }

    /**
     * validate the condition operator
     *
     * @param $operator
     * @throws base_database_Exception
     * @return bool
     */
    private function _validateOperator($operator)
    {
        if (in_array($operator, [self::EQUAL, self::GREATER, self::SMALLER, self::LIKE]) === false) {
            throw new base_database_Exception(TMS(base_database_Exception::NO_VALID_OPERATOR, array('operator' => $operator)));
        }
    }

} 