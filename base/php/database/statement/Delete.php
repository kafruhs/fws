<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 31.08.2014
 * Time: 21:06
 */

class base_database_statement_Delete implements base_database_interface_SetStatement
{
    /**
     * @var base_database_Table
     */
    protected $table;

    /**
     * @var base_database_Where
     */
    protected $where;

    public function setTable(base_database_Table $table)
    {
        $this->table = $table;
    }

    public function setWhere(base_database_Where $where)
    {
        $this->where = $where;
    }

    /**
     * generate sql string
     *
     * @return string
     * @throws base_database_Exception
     */
    public function toString()
    {
        $result = 'DELETE FROM ';
        $result .= $this->table->getName();
        if (empty($this->where)) {
            throw new base_database_Exception(TMS(base_database_Exception::NO_WHERE_GIVEN));
        }
        $result .= ' WHERE ';
        $result .= $this->where->toString();
        return $result;
    }

    /**
     * insert result into database
     *
     * @return int|null
     */
    public function insertDatabase()
    {
        $dbObj = base_database_connection_Mysql::get();
        return $dbObj->execute($this);
    }
}