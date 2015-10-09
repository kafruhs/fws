<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 01.12.2014
 * Time: 21:22
 */

class base_importer_CSV
{
    /**
     * @var array
     */
    private $_data = array();

    /**
     * @var base_database_Table
     */
    protected $table;


    /**
     * load the data to import
     *
     * @param string $pathToImportFile     path the the file, that should be imported
     * @param string $delimiter            delimiter the csv is separated by
     * @param string $tableName            name of the table the import should be made for
     */
    public function __construct($tableName, $pathToImportFile, $delimiter)
    {
        $this->_dataToArray($pathToImportFile, $delimiter);
        $this->table = DB::table($tableName);

    }

    /**
     * @throws base_database_Exception
     */
    public function import()
    {

        DB::beginTransaction();
        foreach ($this->_data as $data) {
            $result = null;
            $where = $this->getWhereForExistingData($data);
            if ($where instanceof base_database_Where) {
                $result = $this->getExistingObjects($where);
            }
            $statement = $this->getStatementForImport($result);
            $statement->setTable($this->table);
            foreach ($data as $colName => $value) {
                $statement->setColumnValue($this->table->getColumn($colName), DB::term($value));
            }
            $statement->insertDatabase();
        }
        DB::endTransaction();
    }

    /**
     * @param array $data
     * @return null|base_database_Where
     */
    protected function getWhereForExistingData(array $data)
    {
        return null;
    }

    /**
     * @param $filename
     * @param string $delimiter
     */
    private function _dataToArray($filename, $delimiter = ';')
    {
        if(!file_exists($filename) || !is_readable($filename)) {
            return;
        }

        $header = null;
        if ($handle = fopen($filename, 'r')) {
            while ($row = fgetcsv($handle, 1000, $delimiter)) {
                if(!$header) {
                    $header = $row;
                }
                else {
                    $this->_data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
    }

    /**
     * @param $where
     * @return array
     */
    private function getExistingObjects($where)
    {
        $colPK = $this->table->getColumn('PK');
        $selectStatement = new base_database_statement_Select();
        $selectStatement->setTable($this->table);
        $selectStatement->setWhere($where);
        $selectStatement->setColumns(array($colPK));
        $result = $selectStatement->fetchDatabase();
        if (empty($result)) {
            return null;
        }
        return $result[0]['PK'];
    }

    /**
     * @param $result
     * @return base_database_statement_Insert|base_database_statement_Update
     * @throws base_database_Exception
     */
    protected function getStatementForImport($result)
    {
        if (empty($result)) {
            $statement = new base_database_statement_Insert();
            return $statement;
        } else {
            $statement = new base_database_statement_Update();
            $colPK = $this->table->getColumn('PK');
            $statement->setWhere(DB::where($colPK, DB::intTerm($result)));
            return $statement;
        }
    }
}