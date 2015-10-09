<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.08.2014
 * Time: 08:36
 */

class base_database_Table
{
    /**
     * name of the table
     *
     * @var string
     */
    protected $name;

    /**
     * columns of the table
     *
     * @var array
     */
    protected $cols = [];

    public function __construct($tableName)
    {
        $this->name = $tableName;
        $columns = new base_database_statement_ShowCol();
        $columns->setTableName($this->getName());
        $this->cols = $columns->fetchDatabase();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($tableName)
    {
        $this->name = $tableName;
    }

    /**
     * @param $colName
     * @return base_database_Column
     * @throws base_database_Exception
     */
    public function getColumn($colName)
    {
        if ($this->existsColumn($colName) === false) {
            throw new base_database_Exception(TMS(base_database_Exception::TABLE_COLUMN_NOT_EXISTS, array('colName' => $colName, 'tableName' => $this->name)));
        }
        return $this->cols[$colName];
    }

    /**
     * @param $colName
     * @return bool
     */
    public function existsColumn($colName)
    {
        return array_key_exists($colName, $this->cols);
    }
} 