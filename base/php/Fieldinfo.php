<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 05.10.2014
 * Time: 16:55
 */

class Fieldinfo
{
    protected $table = 'fieldinfo';

    /**
     * PK of the fieldinfo object
     *
     * @var int
     */
    protected $PK;

    /**
     * name of the class the fieldinfo object is created for
     *
     * @var string
     */
    protected $class;

    /**
     * name of the field
     *
     * @var string
     */
    protected $fieldName;

    /**
     * name of the datatype
     *
     * @var string
     */
    protected $dataType;

    /**
     * label of the field
     *
     * @var string
     */
    protected $fieldLabel;

    /**
     * is the field mandatory
     *
     * @var bool
     */
    protected $mandatory = false;

    /**
     * maximum length of the field
     *
     * @var int
     */
    protected $maxLength;

    /**
     * length of the form element field
     *
     * @var int
     */
    protected $displayedLength;

    /**
     * name of the displayClass for the given field
     *
     * @var string
     */
    protected $displayClass;

    /**
     * the default value of the given field
     *
     * @var mixed
     */
    protected $defaultValue;

    /**
     * @var string
     */
    protected $connectedClass;

    /**
     * @var string
     */
    protected $fieldsOfConnectedClass;

    /**
     * @var   string
     */
    protected $selectionlistName;

    /**
     * @return string
     */
    public function getSelectionlistName()
    {
        return $this->selectionlistName;
    }

    /**
     * @param string $selectionlistName
     */
    public function setSelectionlistName($selectionlistName)
    {
        $this->selectionlistName = $selectionlistName;
    }

    /**
     * @return string
     */
    public function getConnectedClass()
    {
        return $this->connectedClass;
    }

    /**
     * @param string $connectedClass
     */
    public function setConnectedClass($connectedClass)
    {
        $this->connectedClass = $connectedClass;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @param mixed $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * @return int
     */
    public function getDisplayedLength()
    {
        return $this->displayedLength;
    }

    /**
     * @param int $displayedLength
     */
    public function setDisplayedLength($displayedLength)
    {
        $this->displayedLength = $displayedLength;
    }


    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * @param string $fieldName
     */
    public function setFieldName($fieldName)
    {
        $this->fieldName = $fieldName;
    }

    /**
     * @return string
     */
    public function getDataType()
    {
        return ucfirst($this->dataType);
    }

    /**
     * @param string $dataType
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    }

    /**
     * @return boolean
     */
    public function isMandatory()
    {
        if ($this->mandatory == 'N') {
            return false;
        }
        return true;
    }

    /**
     * @param boolean $mandatory
     */
    public function setMandatory($mandatory)
    {
        $this->mandatory = $mandatory;
    }

    /**
     * @return int
     */
    public function getMaxLength()
    {
        return $this->maxLength;
    }

    /**
     * @param int $maxLength
     */
    public function setMaxLength($maxLength)
    {
        $this->maxLength = $maxLength;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getFieldLabel()
    {
        return $this->fieldLabel;
    }

    /**
     * @param string $fieldLabel
     */
    public function setFieldLabel($fieldLabel)
    {
        $this->fieldLabel = $fieldLabel;
    }

    public function getDisplayClass()
    {
        return $this->displayClass;
    }

    /**
     * @return string
     */
    public function getFieldsOfConnectedClass()
    {
        return $this->fieldsOfConnectedClass;
    }

    /**
     * @param string $fieldsOfConnectedClass
     */
    public function setFieldsOfConnectedClass($fieldsOfConnectedClass)
    {
        $this->fieldsOfConnectedClass = $fieldsOfConnectedClass;
    }

    /**
     * @param $class
     * @throws BaseException
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * load the fieldinfo for the given class and fieldName
     *
     * @param $fieldName
     * @throws base_exception_Fieldinfo
     * @throws base_database_Exception
     * @return $this
     */
    public function load($fieldName)
    {
        $cache = base_cache_Fieldinfo::get();
        $result = $cache->getFieldinfo($this->class, $fieldName);
        if (!is_null($result)) {
            return $result;
        }
        $table = DB::table($this->table);
        $colFieldName = $table->getColumn('fieldName');
        $colClass = $table->getColumn('class');
        $where = DB::where($colFieldName, DB::stringTerm($fieldName));
        $where->addAnd($colClass, DB::stringTerm($this->class));
        $sqlStatement = new base_database_statement_Select();
        $sqlStatement->setTable($table);
        $sqlStatement->setWhere($where);
        $result = $sqlStatement->fetchDatabase();

        if (empty($result)) {
            throw new base_exception_Fieldinfo(TMS(base_exception_Fieldinfo::FIELD_NOT_EXISTS, array('field' => $fieldName, 'class' => $this->class)));
        }

        foreach ($result[0] as $field => $value) {
            $this->$field = $value;
        }
        $cache->setFieldinfo($this);
        return $this;
    }

    /**
     * get all fieldinfos for the given class
     *
     * @return Fieldinfo[]|null
     */
    public function getAllFieldinfos()
    {
        $fieldNames = $this->getAllFieldNames();
        $fis = [];
        foreach ($fieldNames as $fieldName) {
            $fi = new self($this->class);
            $fi = $fi->load($fieldName);
            $fis[] = $fi;
        }
        return $fis;
    }

    /**
     * get all fieldNames for the given class
     *
     * @return array
     * @throws base_database_Exception
     */
    public function getAllFieldNames()
    {
        $table = DB::table($this->table);
        $colClass = $table->getColumn('class');
        $where = DB::where($colClass, DB::stringTerm($this->class));
        $sqlStatement = new base_database_statement_Select();
        $sqlStatement->setTable($table);
        $sqlStatement->setWhere($where);
        $sqlStatement->setColumns(array($table->getColumn('fieldName')));
        $result = $sqlStatement->fetchDatabase();
        $fieldNames = [];
        foreach ($result as $row) {
            $fieldNames[] = $row['fieldName'];
        }
        return $fieldNames;
    }

    /**
     * get the corresponding datatype object
     *
     * @return null|Datatype
     */
    public function getDatatypeObject()
    {
        if (empty($this->dataType)) {
            return null;
        }

        $dataTypeClass = "base_datatype_{$this->getDataType()}";
        $dataType = new $dataTypeClass($this);
        return $dataType;
    }
}