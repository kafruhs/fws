<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 31.08.2014
 * Time: 21:06
 */

class base_database_statement_Insert implements base_database_interface_SetStatement
{
    /**
     * @var base_database_Table
     */
    protected $table;

    /**
     * @var array[]
     */
    protected $columnValues;

    /**
     * @param base_database_Table $table
     */
    public function setTable(base_database_Table $table)
    {
        $this->table = $table;
    }

    /**
     * @param base_database_Column $column
     * @param base_database_interface_Term $term
     * @throws base_database_Exception
     */
    public function setColumnValue(base_database_Column $column, base_database_interface_Term $term)
    {
        if ($this->table->existsColumn($column->getName()) === false) {
            throw new base_database_Exception(base_database_Exception::TABLE_COLUMN_NOT_EXISTS);
        }
        $this->columnValues[$column->getName()] =  $term->toString();
    }

    /**
     * @return array[]
     */
    public function getColumnValues()
    {
        return $this->columnValues;
    }

    /**
     * generate sql string
     *
     * @return string
     */
    public function toString()
    {
        if (empty($this->columnValues)) {
            return '';
        }
        $result = 'INSERT INTO ';
        $result .= $this->table->getName();
        $result .= ' (' . implode(',', array_keys($this->columnValues)) . ') ';
        $result .= 'VALUES (' . implode(',', array_values($this->columnValues)) . ')';
        return $result;
    }

    /**
     * insert result into database
     *
     * @return int|null
     */
    public function insertDatabase()
    {
        if (empty($this->columnValues) === true) {
            return null;
        }
        $dbObj = base_database_connection_Mysql::get();
        return $dbObj->execute($this);
    }
}