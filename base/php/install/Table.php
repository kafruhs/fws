<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.01.2015
 * Time: 10:29
 */

class base_install_Table implements base_database_interface_SetStatement
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string[]
     */
    protected $columns = array();

    public function __construct($tableName)
    {
        $this->name = $tableName;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function addColumn(base_install_Column $column)
    {
        $this->columns[] = $column->toString();
    }

    /**
     * generate sql string
     * @return string
     * @throws base_database_Exception
     */
    public function toString()
    {
        if (empty($this->columns)) {
            throw new base_database_Exception(TMS(base_database_Exception::NO_COLS_ADDED, array('tableName', $this->name)));
        }
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $this->name . ' (';
        $sql .= implode(', ', $this->columns) . ')';
        return $sql;
    }

    /**
     * insert result into database
     *
     * @return int
     */
    public function insertDatabase()
    {
        $dbObj = base_database_connection_Mysql::get();
        $dbObj->beginTransaction();
        $lastKey = $dbObj->execute($this);
        $dbObj->endTransaction();
        return $lastKey;
    }
}