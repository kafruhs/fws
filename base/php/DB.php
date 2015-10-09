<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 31.08.2014
 * Time: 22:02
 */

class DB
{
    /**
     * get a table by its tablename
     *
     * @param $tableName
     * @return base_database_Table
     */
    public static function table($tableName)
    {
        return new base_database_Table($tableName);
    }

    /**
     * get a where condition object
     *
     * @param base_database_Column $column
     * @param base_database_interface_Term $value
     * @param string $op
     * @return base_database_Where
     */
    public static function where(base_database_Column $column, base_database_interface_Term $value, $op = base_database_Where::EQUAL)
    {
        return new base_database_Where($column, $value, $op);
    }

    /**
     * get an order object
     *
     * @param base_database_Column $column
     * @param string $direction
     * @return base_database_Order
     */
    public static function order(base_database_Column $column, $direction = base_database_Order::DESC)
    {
        return new base_database_Order($column, $direction);
    }

    /**
     * get an int term
     *
     * @param $value
     * @return \base_database_term_Int
     * @throws base_database_Exception
     */
    public static function intTerm($value)
    {
        $term = new base_database_term_Int();
        $term->setValue($value);
        return $term;
    }

    /**
     * get a string term
     *
     * @param $value
     * @return \base_database_term_String
     * @throws base_database_Exception
     */
    public static function stringTerm($value)
    {
        $term = new base_database_term_String();
        $term->setValue($value);
        return $term;
    }

    /**
     * get a string term
     *
     * @param $value
     * @return \base_database_term_String
     * @throws base_database_Exception
     */
    public static function term($value)
    {
        try {
            $term = new base_database_term_String();
            $term->setValue($value);
        } catch (base_database_Exception $e) {
            $term = new base_database_term_Int();
            $term->setValue($value);
        }
        return $term;
    }

    /**
     * begin a database transaction
     *
     * @throws base_database_Exception
     */
    public static function beginTransaction()
    {
        base_database_connection_Mysql::get()->beginTransaction();
    }

    /**
     * end a database transaction
     */
    public static function endTransaction()
    {
        base_database_connection_Mysql::get()->endTransaction();
    }
}