<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 31.08.2014
 * Time: 21:06
 */

class base_database_statement_Update implements base_database_interface_SetStatement
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
     * @var base_database_Where
     */
    protected $where;

    public function setTable(base_database_Table $table)
    {
        $this->table = $table;
    }

    public function setColumnValue(base_database_Column $column, base_database_interface_Term $term)
    {
        if ($this->table->existsColumn($column->getName()) === false) {
            throw new base_database_Exception(base_database_Exception::TABLE_COLUMN_NOT_EXISTS);
        }
        $this->columnValues[] = $column->getName() . ' = ' . $term->toString();
    }

    public function getColumnValues()
    {
        return $this->columnValues;
    }

    public function setWhere(base_database_Where $where)
    {
        $this->where = $where;
    }

    /**
     * generate sql string
     *
     * @return string
     */
    public function toString()
    {
        $result = 'UPDATE ';
        $result .= $this->table->getName();
        $result .= ' SET ';
        if (empty($this->columnValues) === false) {
            $result .= implode(', ', $this->columnValues);
        }
        if (empty($this->where) === false) {
            $result .= ' WHERE ';
            $result .= $this->where->toString();
        }
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