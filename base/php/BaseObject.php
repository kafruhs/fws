<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.08.2014
 * Time: 08:02
 */

class BaseObject implements  ArrayAccess
{
    /**
     * load by LK and with histtop = BaseObject::ACTUAL
     */
    const LOAD_LK       = 1;

    /**
     * load by PK independend if the revision of the object is BaseObject::HISTORIC, BaseObject::DELETED or BaseObject::ACTUAL
     */
    const LOAD_PK       = 2;

    /**
     * load only deleted revisions by LK of the object (histtop = BaseObject::DELETED
     */
    const LOAD_DELETED  = 3;

    /**
     * actual revision of the object
     */
    const ACTUAL = 'Y';

    /**
     * historic revision of the object
     */
    const HISTORIC = 'N';

    /**
     * deleted revision of the object
     */
    const DELETED = 'D';

    /**
     * the object was successfully saved
     */
    const SAVE_SUCCESS = 1;

    /**
     * the object can not be saved, because there are no changes in field values
     */
    const SAVE_NOCHANGES = 2;

    /**
     * the object could not be saved
     */
    const SAVE_FAILURE = 3;

    /**
     * the object was successfull deleted
     */
    const DELETE_SUCCESS = 1;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var array with column names, that should be imported.
     */
    protected $colNamesForImport = array();

    /**
     * columns, that will be displayed in searchresults, if not different specified in url
     *
     * @var array
     */
    protected $stdSearchColumns = array('LK', 'firstEditor', 'firstEditTime', 'editor', 'editTime', 'histtop');


    protected $fieldsForPDF = array(
        'PK',
        'LK',
        'firstEditor',
        'firstEditTime',
        'editor',
        'editTime',
    );

    protected $mnFields = [];

    /**
     * this parameter is set to false, if the object was loaded
     *
     * @var bool
     */
    private $_newObject = true;

    /**
     * array with the data of the object, that is used for offset
     *
     * @var array
     */
    private $_fields = [];

    /**
     * loading is in progress
     *
     * @var bool
     */
    private $_loadInProgress = false;

    /**
     * @var bool should the file cache be used
     */
    protected $useCache = true;

    /**
     * stores information about the object has changed field values
     *
     * @var bool
     */
    private $_changed = false;

    /**
     * @var string  Permission needed to read objects of this class
     */
    protected $readPermission = Permission::BENUTZER;

    /**
     * @var string  Permission needed to add a new object of this class
     */
    protected $writePermission = Permission::BENUTZER;

    /**
     * @var string  Permission needed to delete an object of this class
     */
    protected $deletePermission = Permission::BENUTZER;

    /**
     * @return array
     */
    public function getMnFields()
    {
        return $this->mnFields;
    }

    /**
     * @return boolean
     */
    public function isNewObject()
    {
        return $this->_newObject;
    }


    /**
     * @return string
     */
    public function getReadPermissionName()
    {
        return $this->readPermission;
    }

    /**
     * @return string
     */
    public function getWritePermissionName()
    {
        return $this->writePermission;
    }

    /**
     * @return string
     */
    public function getDeletePermissionName()
    {
        return $this->deletePermission;
    }

    /**
     * set the object::changed property to false
     */
    public function setChangedFalse()
    {
        $this->_changed = false;
    }

    public function setNewObjectFalse()
    {
        $this->_newObject = false;
    }

    public function __construct()
    {
    }

    /**
     * @return array
     */
    public function getFieldsForPDF()
    {
        return $this->fieldsForPDF;
    }

    /**
     * @param array $fieldsForPDF
     */
    public function setFieldsForPDF(array $fieldsForPDF)
    {
        $this->fieldsForPDF = $fieldsForPDF;
    }

    /**
     * Whether a offset exists
     * @param mixed $offset An offset to check for.
     *
     * @return boolean true on success or false on failure.
     */
    public function offsetExists($offset)
    {
        return isset($this->_fields[$offset]);
    }

    /**
     * Offset to retrieve
     * @param mixed $offset The offset to retrieve.
     *
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->getField($offset, false);
    }

    /**
     * Offset to set
     * @param mixed $offset The offset to assign the value to.
     *
     * @param mixed $value The value to set.
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (isset($this->_fields[$offset]) && $this->_fields[$offset] == $value){
            return;
        }
        $fi    = $this->getFieldinfo($offset);
        if (!isset($this->_fields[$offset]) && empty($value)) {
            $this->_fields[$offset] = null;
            return;
        }

        if (!isset($this->_fields[$offset])) {
            $this->_fields[$offset] = null;
        }

        if (empty($this->_fields[$offset]) && empty($value)) {
            return;
        }

        $dtObj = $fi->getDatatypeObject();
        if (!$this->_loadInProgress) {
            $value = $dtObj->toInternal($value);
        } else {
            $value = $dtObj->fromDB($value);
        }
        if ($this->_fields[$offset] == $value) {
            return;
        }

        $this->_fields[$offset] = $value;
        $this->_changed = true;
    }

    /**
     * get the field value
     *
     * @param string    $fieldName
     * @param bool      $resolve
     * @return mixed
     */
    public function getField($fieldName, $resolve = true)
    {
        if (!isset($this->_fields[$fieldName])) {
            if (in_array($fieldName, $this->mnFields)) {
                return [];
            }
            return null;
        }
        if ($resolve == false) {
            return $this->_fields[$fieldName];
        }

        $fi = $this->getFieldinfo($fieldName);
        $dtObj = $fi->getDatatypeObject();
        return $dtObj->toExternal($this->_fields[$fieldName]);

    }

    /**
     * Offset to unset
     * @param mixed $offset The offset to unset.
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->_fields[$offset]);
    }

    /**
     * @return array
     */
    public function getColNamesForImport()
    {
        return $this->colNamesForImport;
    }

    /**
     * @param array $colNamesForImport
     */
    public function setColNamesForImport($colNamesForImport)
    {
        $this->colNamesForImport = $colNamesForImport;
    }

    /**
     * get the name of the class db table
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * get the PK of the Object
     *
     * @return int
     */
    public function getPhysicalKey()
    {
        return $this->_fields['PK'];
    }

    /**
     * get the LK of the Object
     *
     * @return int
     */
    public function getLogicalKey()
    {
        return (int) $this->_fields['LK'];
    }

    /**
     * does the given field name exist?
     *
     * @param string $name  name of the field
     * @return bool
     */
    public function existsField($name)
    {
        return isset($this->_fields[$name]);
    }

    /**
     * load an object from the database
     *
     * @param int $key          depending on loadmode PK or LK
     * @param int $loadmode     see self::LOAD_LK, etc.
     * @return $this
     * @throws BaseException
     */
    public function load($key, $loadmode = self::LOAD_LK)
    {
        $historic = null;
        $keyField = 'LK';
        switch ($loadmode) {
            case self::LOAD_LK:
                $historic = self::ACTUAL;
                break;
            case self::LOAD_PK:
                $keyField = 'PK';
                break;
            case self::LOAD_DELETED:
                $historic = self::DELETED;
        }
        $result = null;
        $cache = base_cache_BaseObject::get(get_class($this));
        if ($loadmode == self::LOAD_LK && $this->useCache) {
            $result = $cache->getCacheEntry((int) $key);
        }
        if (!is_null($result)) {
            $result->setChangedFalse();
            $result->setNewObjectFalse();
            return $result;
        }
        $data = $this->_loadData((int) $key, $keyField, $historic);

        if (empty($data)) {
            return null;
        }

        $this->_loadInProgress = true;
        foreach ($data as $fieldName => $value) {
            $this[$fieldName] = $value;
        }
        if (!empty($this->mnFields)) {
            $this->_loadMNFields();
        }
        $this->_loadInProgress = false;
        $this->_newObject = false;
        $this->_changed = false;
        if ($this->useCache) {
            $cache->setCacheEntry($this);
        }
        return $this;
    }

    /**
     * save the object to the db
     *
     * @return int
     */
    public function save()
    {
        if ($this->isChanged() == false) {
            return self::SAVE_NOCHANGES;
        }
//        $dbObj = base_database_connection_Mysql::get();
//        $dbObj->beginTransaction();
        $table = DB::table($this->table);

        $this->_setLastEditorAndEditTime();
        if ($this->_newObject) {
            $this->_setFirstEditorData();
        } else {
            $this->_setHistoricData($table, self::HISTORIC);
        }
        $this->_insertNewData($table);

        if ($this->useCache) {
            $cache = base_cache_BaseObject::get(get_class($this));
            $cache->setCacheEntry($this);
        }

//        $dbObj->endTransaction();
        return self::SAVE_SUCCESS;
    }

    /**
     * has the object changed field values?
     *
     * @return bool
     */
    public function isChanged()
    {
        return $this->_changed;
    }

    /**
     * get a fieldinfo for the given field name
     *
     * @param string     $fieldName
     * @return Fieldinfo
     */
    public function getFieldinfo($fieldName)
    {
        $fi = new Fieldinfo(get_class($this));
        $fi = $fi->load($fieldName);
        return $fi;
    }

    /**
     * @return array
     */
    public function getStdSearchColumns()
    {
        return $this->stdSearchColumns;
    }

    /**
     * @param array $stdSearchColumns
     */
    public function setStdSearchColumns($stdSearchColumns)
    {
        $this->stdSearchColumns = $stdSearchColumns;
    }

    /**
     * get all fieldinfos for the object
     *
     * @return Fieldinfo[]|null
     */
    public function getAllFields()
    {
        $fi = new Fieldinfo(get_class($this));
        $fis = $fi->getAllFieldinfos();
        return $fis;
    }

    /**
     * Displayed name of this class
     *
     * @return string
     */
    public function getDisplayName()
    {
        return get_class($this);
    }

    /**
     * delete a BaaseObject
     */
    public function delete()
    {
        $table = DB::table($this->table);

        $this->_setLastEditorAndEditTime();
        $this->_setHistoricData($table, self::HISTORIC);
        $this['histtop'] = self::DELETED;
        foreach ($this->mnFields as $fieldName) {
            $this[$fieldName] = array();
        }
        $this->_insertNewData($table);

        if ($this->useCache) {
            $cache = base_cache_BaseObject::get(get_class($this));
            $cache->deleteCacheEntry($this);
        }

//        $dbObj->endTransaction();
        return self::DELETE_SUCCESS;
    }

    /**
     * load the data for the object to load
     *
     * @param $key
     * @param $keyField
     * @param $historic
     *
     * @throws BaseException
     * @throws base_database_Exception
     * @return array
     */
    private function _loadData($key, $keyField, $historic)
    {
        $table = DB::table($this->getTable());
        $where = DB::where($table->getColumn($keyField), DB::intTerm($key));
        if (!empty($historic)) {
            $where->addAnd($table->getColumn('histtop'), DB::stringTerm($historic));
        }
        $selectStatement = new base_database_statement_Select();
        $selectStatement->setTable($table);
        $selectStatement->setWhere($where);
        $result = $selectStatement->fetchDatabase();
        if (count($result) > 1) {
            throw new BaseException('Einfügen Zeile 160 BaseObject');
        }

        if (empty($result)) {
            return null;
        }
        return $result[0];
    }

    /**
     * if the object is inserted into the db for the first time some fields e.g. LK, firstEditor must be set
     */
    private function _setFirstEditorData()
    {
        $this['firstEditor'] = Flat::user()->getLogicalKey();
        $this['firstEditTime'] = new base_date_model_DateTime();
        $seq = new Sequence(get_class($this));
        $this['LK'] = $seq->getNextSequence();
        $seq->save();
    }

    /**
     * set existing actual revision of the object to self::HISTORIC
     *
     * @param $table
     * @param $historicValue
     * @return base_database_statement_Update
     * @throws base_database_Exception
     */
    private function _setHistoricData(base_database_Table $table, $historicValue)
    {
        $statement = new base_database_statement_Update();
        $where = DB::where($table->getColumn('histtop'), DB::term(self::ACTUAL));
        $where->addAnd($table->getColumn('LK'), DB::intTerm((int) $this['LK']));
        $statement->setTable($table);
        $statement->setWhere($where);
        $statement->setColumnValue($table->getColumn('histtop'), DB::term($historicValue));
        $statement->insertDatabase();
    }

    /**
     * insert a new revision of the given Object
     *
     * @param base_database_Table
     * @throws base_database_Exception
     */
    private function _insertNewData(base_database_Table $table)
    {
        $statement = new base_database_statement_Insert();
        $statement->setTable($table);
        foreach ($this->_fields as $fieldName => $value) {
            if (empty($value) || $fieldName == 'PK') {
                continue;
            }
            if (in_array($fieldName, $this->mnFields)) {
                continue;
            }
            $fi = $this->getFieldinfo($fieldName);
            $dtObj = $fi->getDatatypeObject();
            $value = $dtObj->toDB($value);
            $statement->setColumnValue($table->getColumn($fieldName), DB::term($value));
        }
        $statement->insertDatabase();
        foreach ($this->mnFields as $fieldName) {
            $fi = $this->getFieldinfo($fieldName);
            $this->_saveMNField($fi);
        }
    }

    /**
     * set the last editor and the actual timestamp
     */
    private function _setLastEditorAndEditTime()
    {
        $user = Flat::user();
        $this['editor'] = $user->getLogicalKey();
        $this['editTime'] = new base_date_model_DateTime();
    }

    private function _loadMNFields()
    {
        foreach ($this->mnFields as $mnField) {
            $this[$mnField] = $this->getLogicalKey();
        }
    }

    private function _saveMNField(Fieldinfo $fi)
    {
        if (empty($this->_fields[$fi->getFieldName()])) {
            return;
        }
        /** @var BaseConnectionObject[] $connObjects */
        $connObjects = $this->_fields[$fi->getFieldName()];
        $objClass = get_class($this);
        $connClass = $fi->getConnectedClass();
        /** @var BaseConnectionObject $connection */
        $connection = new $connClass();
        $otherClass = $connection->getOtherClass($objClass);
        $existingConnObjs = $connection->find($this->getLogicalKey(), $objClass);

        if (empty($connObjects) && empty($existingConnObjs)) {
            return;
        }

        if (empty($connObjects)) {
            $this->_deleteConnObjs($existingConnObjs);
        }

        $savedLKList = [];
        $actualLKList = [];

        foreach ($existingConnObjs as $obj) {
            $savedLKList[$obj->getLKForClass($otherClass)] = $obj;
        }

        foreach ($connObjects as $connObj) {
            $lk = $connObj->getLKForClass($otherClass);
            if (in_array($lk, array_keys($savedLKList))) {
                $actualLKList[] = $lk;
                continue;
            }
            $connObj->setLKForClass($objClass, $this->getLogicalKey());
            $connObj->save();
        }

        $diff = array_diff(array_keys($savedLKList), $actualLKList);
        foreach ($diff as $otherLK) {
            /** @var BaseConnectionObject $connObj */
            $connObj = $savedLKList[$otherLK];
            $connObj->delete();
        }
    }

    /**
     * delete existing BaseConnObjects
     *
     * @param BaseConnectionObject[] $connObjs
     */
    private function _deleteConnObjs(array $connObjs)
    {
        foreach ($connObjs as $connObj) {
            $connObj->delete();
        }
    }

    public function getPermissionForViewMode($viewMode)
    {
        if (!in_array($viewMode, array(DisplayClass::EDIT, DisplayClass::VIEW))) {
            throw new base_displayclass_Exception(TMS(base_displayclass_Exception::NOT_SUPPORTED_MODE));
        }

        if ($viewMode == DisplayClass::VIEW) {
            return $this->getReadPermissionName();
        }

        if ($viewMode == DisplayClass::EDIT) {
            return $this->getWritePermissionName();
        }
    }
}