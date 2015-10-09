<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.08.2014
 * Time: 17:43
 */

class base_database_statement_ShowCol implements base_database_interface_GetStatement
{
    /**
     * name of the table the columns should be displayed for
     *
     * @var string
     */
    protected $tableName;

    /**
     * @param string $tableName
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * generate sql string
     *
     * @return string
     */
    public function toString()
    {
        return "SHOW COLUMNS FROM {$this->tableName}";
    }

    /**
     * fetch the result from database
     *
     * @return array
     * @throws base_database_Exception
     */
    public function fetchDatabase()
    {
        $this->_validateTableNameNotEmpty();
        $dbObj = base_database_connection_Mysql::get();
        $result = $dbObj->query($this);
        return $this->transformDBResultToColumns($result);
    }

    /**
     * validate the table name is not empty
     *
     * @return bool
     */
    private function _validateTableNameNotEmpty()
    {
        return empty($this->tableName);
    }

    /**
     * transform DB result to base_database_Column format
     *
     * @param $result
     * @return array
     */
    private function transformDBResultToColumns($result)
    {
        $colList = [];
        foreach ($result as $colEntry) {
            $col = new base_database_Column();
            $col->setName($colEntry['Field']);
            if (strpos($colEntry['Type'], '(') === false) {
                $col->setType($colEntry['Type']);
            } else {
                list($type, $length) = explode('(', $colEntry['Type']);
                $col->setType($type);
                $col->setLength(str_ireplace(')', '', $length));
            }
            if ($colEntry['Null'] != base_database_Column::NOT_NULL) {
                $col->setNull();
            }
            if ($colEntry['Key'] === base_database_Column::PRIMARY_KEY) {
                $col->setPrimary();
            }
            if (empty($colEntry['Default']) === false) {
                $col->setDefault($colEntry['Default']);
            }
            if ($colEntry['Extra'] === base_database_Column::AUTO_INCREMENT) {
                $col->setAutoIncrement();
            }
            $colList[$colEntry['Field']] = $col;

        }
        return $colList;
    }
}