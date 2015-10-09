<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 24.08.2014
 * Time: 16:06
 */

class base_database_statement_Select implements  base_database_interface_GetStatement
{
    /**
     * @var base_database_Column[]
     */
    protected $columns = array();

    /**
     * @var base_database_table
     */
    protected $table;

    /**
     * @var base_database_Where
     */
    protected $where;

    /**
     * @var base_database_Order
     */
    protected $order;

    /**
     * @var base_database_Limit
     */
    protected $limit;

    /**
     * set a list of columns for the select statement
     *
     * @param array $columnList
     * @throws base_database_Exception
     */
    public function setColumns(array $columnList)
    {
        $this->_validateColumns($columnList);
        $this->columns = $columnList;
    }

    /**
     * set the table for the select statement
     *
     * @param base_database_Table $table
     */
    public function setTable(base_database_Table $table)
    {
        $this->table = $table;
    }

    /**
     * set the where condition
     *
     * @param base_database_Where $where
     */
    public function setWhere(base_database_Where $where)
    {
        $this->where = $where;
    }

    /**
     * set the selection ordering
     *
     * @param base_database_Order $order
     */
    public function setOrder(base_database_Order $order)
    {
        $this->order = $order;
    }

    public function setLimit(base_database_Limit $limit)
    {
        $this->limit = $limit;
    }

    /**
     * return the statement in string format
     *
     * @return string
     */
    public function toString()
    {
        $result = 'SELECT ';
        $columnNames = $this->_getColumnNames();
        if (empty($columnNames) === true) {
            $result .= '*';
        } else {
            $result .= implode(', ', $columnNames);
        }
        $result .= ' FROM ';
        $result .= $this->table->getName();
        if (isset($this->where) === true) {
            $result .= ' WHERE ';
            $result .= $this->where->toString();
        }
        if (isset($this->order) === true) {
            $result .= ' ORDER BY ';
            $result .= $this->order->toString();
        }

        if (isset($this->limit) === true) {
            $result .= ' LIMIT ';
            $result .= $this->limit->toString();
        }

        return $result;
    }

    /**
     * fetch the result from database
     *
     * @return array
     * @throws base_database_Exception
     */
    public function fetchDatabase()
    {
        $dbObj = base_database_connection_Mysql::get();
        return $dbObj->query($this);
    }

    /**
     * validate the column entries to be instance of base_database_Column
     *
     * @param array $columnList
     * @throws base_database_Exception
     */
    private function _validateColumns(array $columnList)
    {
        foreach($columnList as $column) {
            if ($column instanceof base_database_Column === false) {
                throw new base_database_Exception(base_database_Exception::TABLE_COLUMN_NOT_EXISTS);
            }
        }
    }

    /**
     * get the names of the selected columns
     *
     * @return array
     */
    private function _getColumnNames()
    {
        $columnNames = [];
        foreach ($this->columns as $column) {
            $columnNames[] = $column->getName();
        }
        return $columnNames;
    }
} 