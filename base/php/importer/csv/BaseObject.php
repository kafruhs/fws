<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.12.2014
 * Time: 17:52
 */

class base_importer_csv_BaseObject
{
    const SUCCESS = 0;

    const NO_DATA = 1;

    const FAILURE = 2;

    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var BaseObject
     */
    protected $obj;

    public function __construct($class, $filePath, $delimiter = ';', $hasHeader = true)
    {
        $this->obj = Factory::createObject($class);
        $this->loadData($filePath, $delimiter, $hasHeader);
    }

    public function import()
    {
        if (empty($this->data)) {
            return self::NO_DATA;
        }
        $dbObj = base_database_connection_Mysql::get();
        $dbObj->beginTransaction();
        foreach ($this->data as $data) {
            if ($this->isIrrelevantData($data)) {
                continue;
            }
            $result = null;
            $obj = clone $this->obj;
            $where = $this->getWhereForFindExistingData($data);
            if ($where instanceof base_database_Where) {
                $result = $this->getExistingObjects($where);
            }

            if (!is_null($result)) {
                $obj->load($result, BaseObject::LOAD_PK);
            }
            foreach ($data as $colName => $value) {
                $mapper = base_mapper_Factory::createObject(get_class($obj), $colName);
                if (!is_null($mapper)) {
                    $mapper->setCurrentDataSet($data);
                    $value = $mapper->mapFieldValue($value);
                }
                $obj[$colName] = $value;
            }
            $obj->save();
        }
        $dbObj->endTransaction();
        return self::SUCCESS;
    }

    public function importCMD()
    {
        if (empty($this->data)) {
            return self::NO_DATA;
        }
        $i = 0;
        echo '+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++';
        echo '----- Import der Klasse ' . get_class($this->obj) . ' -----';
        $microStart = time();
        $dbObj = base_database_connection_Mysql::get();
        $dbObj->beginTransaction();
        foreach ($this->data as $data) {
            if ($i % 50 == 0) {
                echo PHP_EOL . "$i/" . count($this->data);
            }
            if ($this->isIrrelevantData($data)) {
                echo 'S';
                $i++;
                continue;
            }
            $result = null;
            $obj = clone $this->obj;
            $where = $this->getWhereForFindExistingData($data);
            if ($where instanceof base_database_Where) {
                $result = $this->getExistingObjects($where);
            }

            if (!is_null($result)) {
                $obj->load($result, BaseObject::LOAD_PK);
            }
            foreach ($data as $colName => $value) {
                $mapper = base_mapper_Factory::createObject(get_class($obj), $colName);
                if (!is_null($mapper)) {
                    $mapper->setCurrentDataSet($data);
                    $value = $mapper->mapFieldValue($value);
                }
                $obj[$colName] = $value;
            }
            if ($obj->save() == BaseObject::SAVE_NOCHANGES) {
                echo 'S';
            } else {
                echo '.';
            }
            $i++;
        }
        $microEnd = time();
        $diff = $microEnd - $microStart;
        echo PHP_EOL . "----- Dauer: " . $diff . " Sekunden" . PHP_EOL . PHP_EOL;
        echo '+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++' . PHP_EOL;
        $dbObj->endTransaction();
        return self::SUCCESS;
    }

    protected function loadData($filePath, $delimiter, $hasHeader)
    {
        if(!file_exists($filePath) || !is_readable($filePath)) {
            return;
        }

        $header = null;
        if ($handle = fopen($filePath, 'r')) {
            while ($row = fgetcsv($handle, 1000, $delimiter)) {
                if(!$header && $hasHeader) {
                    $header = $row;
                    continue;
                }

                if (!$header) {
                    $header = $this->obj->getColNamesForImport();
                }
                $data = array_combine($header, $row);
                $data = $this->addValuesToData($data);
                $this->data[] = $data;
            }
            fclose($handle);
        }
    }

    /**
     * add a colName Value pair to the data array
     *
     * @param array $data
     * @return array
     */
    protected function addValuesToData(array $data)
    {
        return $data;
    }

    /**
     * @param $where
     * @return int
     */
    private function getExistingObjects($where)
    {
        $table = DB::table($this->obj->getTable());
        $colPK = $table->getColumn('PK');

        $finder = Finder::create(get_class($this->obj));
        $result = $finder->setWhere($where)->find(array($colPK));

        if (empty($result)) {
            return null;
        }
        return $result[0]['PK'];
    }

    /**
     */
    protected function getWhereForFindExistingData(array $data)
    {
        if (!isset($data['PK'])) {
            return null;
        }
        $table = DB::table($this->obj->getTable());
        $column = $table->getColumn('PK');
        $where = DB::where($column, DB::term((int) $data['PK']));
        $where->addAnd($table->getColumn('histtop'), DB::term('Y'));
        return $where;
    }

    protected function isIrrelevantData(array $data)
    {
        return false;
    }
}