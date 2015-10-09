<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 24.05.2015
 * Time: 13:05
 */

class BaseConnectionObject
{
    const SAVE_VALIDATION_SUCCESSFULL = 0;

    const SAVE_OBJECT_ALREADY_EXISTS = 1;

    const SAVE_NOT_PERFORMED = 1;

    const SAVE_SUCCESSFULL = 0;

    protected $table = 'connectionObjects';

    /**
     * @var int
     */
    protected $PK;

    protected $classLeft;

    protected $classRight;

    protected $lkLeft;

    protected $lkRight;

    public function __construct()
    {
        $this->_checkClassFields();
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return mixed
     */
    public function getClassLeft()
    {
        return $this->classLeft;
    }

    /**
     * @return mixed
     */
    public function getClassRight()
    {
        return $this->classRight;
    }

    /**
     * @return int
     */
    public function getLkLeft()
    {
        return $this->lkLeft;
    }

    /**
     * @param int $lkLeft
     */
    public function setLkLeft($lkLeft)
    {
        $this->lkLeft = (int) $lkLeft;
    }

    /**
     * @return int
     */
    public function getLkRight()
    {
        return $this->lkRight;
    }

    /**
     * @param int $lkRight
     */
    public function setLkRight($lkRight)
    {
        $this->lkRight = (int) $lkRight;
    }

    /**
     * @throws base_exception_BaseConnectionObject
     */
    private function _checkClassFields()
    {
        if (!isset($this->classLeft) || !isset($this->classRight)) {
            throw new base_exception_BaseConnectionObject(TMS(base_exception_BaseConnectionObject::CLASSNAMES_NOT_SET));
        }
    }

    /**
     * @param $lk
     * @param $class
     * @return BaseConnectionObject[]
     * @throws base_database_Exception
     * @throws base_exception_BaseConnectionObject
     */
    public function find ($lk, $class)
    {
        if (strtolower($class) == strtolower($this->classRight)) {
            $searchCol = "lkRight";
        } elseif (strtolower($class) == strtolower($this->classLeft)) {
            $searchCol = "lkLeft";
        } else {
            throw new base_exception_BaseConnectionObject(TMS(base_exception_BaseConnectionObject::USE_CLASS_CONST));
        }
        $table = DB::table($this->table);
        $colClassLK = $table->getColumn($searchCol);
        $where = DB::where($colClassLK, DB::term($lk));
        $sqlStatement = new base_database_statement_Select();
        $sqlStatement->setTable($table);
        $sqlStatement->setWhere($where);
        $result = $sqlStatement->fetchDatabase();

        $colObjects = [];
        foreach ($result as $row) {
            $colObjects[] = clone $this->_setObject($row);
        }
        return $colObjects;
    }

    /**
     * @param $sqlValues
     * @return $this
     */
    private function _setObject($sqlValues)
    {
        foreach ($sqlValues as $field => $value) {
            $this->$field = $value;
        }
        return $this;
    }

    /**
     * @param $class
     * @return mixed
     * @throws base_exception_BaseConnectionObject
     */
    public function getOtherClass($class)
    {
        if (strtolower($class) == strtolower($this->getClassLeft())) {
            return $this->getClassRight();
        } elseif (strtolower($class) == strtolower($this->getClassRight())) {
            return $this->getClassLeft();
        } else {
            throw new base_exception_BaseConnectionObject(TMS(base_exception_BaseConnectionObject::CLASS_NOT_EXISTS));
        }
    }

    /**
     * @param $class
     * @return mixed
     * @throws base_exception_BaseConnectionObject
     */
    public function getLKForClass($class) {
        if (strtolower($class) == strtolower($this->getClassLeft())) {
            return $this->getLkLeft();
        } elseif (strtolower($class) == strtolower($this->getClassRight())) {
            return $this->getLKRight();
        } else {
            throw new base_exception_BaseConnectionObject(TMS(base_exception_BaseConnectionObject::CLASS_NOT_EXISTS));
        }
    }

    /**
     * set the lk for the given class
     *
     * @param $class
     * @param $lk
     */
    public function setLKForClass($class, $lk)
    {
        $class = strtolower($class);
        if (strtolower($this->classLeft) == $class) {
            $this->lkLeft = $lk;
        }
        if (strtolower($this->classRight) == $class) {
            $this->lkRight = $lk;
        }
    }

    /**
     * set the lk for the given class
     *
     * @param $class
     * @param $otherLK
     */
    public function setOtherLKForClass($class, $otherLK)
    {
        $class = strtolower($class);
        if (strtolower($this->classLeft) == $class) {
            $this->setLKForClass($this->classRight, $otherLK);
        }
        if (strtolower($this->classRight) == $class) {
            $this->setLKForClass($this->classLeft, $otherLK);
        }
    }

    /**
     * saves the given Connection
     *
     * @throws base_exception_BaseConnectionObject
     */
    public function save()
    {
        if ($this->_validateNeededInformation() != self::SAVE_VALIDATION_SUCCESSFULL) {
            return self::SAVE_OBJECT_ALREADY_EXISTS;
        }
        $insert = new base_database_statement_Insert();
        $table = DB::table($this->table);
        $insert->setTable($table);
        $properties = ['classLeft', 'classRight', 'lkLeft', 'lkRight'];
        foreach ($properties as $property) {
            $insert->setColumnValue($table->getColumn($property), DB::term($this->$property));
        }
        $insert->insertDatabase();
        return self::SAVE_SUCCESSFULL;
    }

    /**
     * validates the given values for the properties
     *
     * @throws base_exception_BaseConnectionObject
     */
    private function _validateNeededInformation()
    {
        $properties = ['classLeft', 'classRight', 'lkLeft', 'lkRight'];
        foreach ($properties as $property) {
            if (!isset($this->$property)) {
                throw new base_exception_BaseConnectionObject(TMS(base_exception_BaseConnectionObject::PROPERTY_NOT_SET, array('property' => $property)));
            }
        }

        if (is_null(Factory::loadObject($this->classLeft, $this->lkLeft))) {
            throw new base_exception_BaseConnectionObject(TMS(base_exception_BaseConnectionObject::OBJECT_NOT_EXISTS, array('class' => $this->classLeft, 'lk' => $this->lkLeft)));
        }

        if (is_null(Factory::loadObject($this->classRight, $this->lkRight))) {
            throw new base_exception_BaseConnectionObject(TMS(base_exception_BaseConnectionObject::OBJECT_NOT_EXISTS, array('class' => $this->classRight, 'lk' => $this->lkRight)));
        }

        $select = new base_database_statement_Select();
        $table = DB::table($this->table);
        $select->setTable($table);
        $where = DB::where($table->getColumn('classLeft'), DB::term($this->classLeft));
        $where->addAnd($table->getColumn('classRight'), DB::term($this->classRight));
        $where->addAnd($table->getColumn('lkRight'), DB::term($this->lkRight));
        $where->addAnd($table->getColumn('lkLeft'), DB::term($this->lkLeft));
        $select->setWhere($where);
        $result = $select->fetchDatabase();
        if (!empty($result)) {
            return self::SAVE_OBJECT_ALREADY_EXISTS;
        }
        return self::SAVE_VALIDATION_SUCCESSFULL;
    }

    public function delete()
    {
        $deleteStatement = new base_database_statement_Delete();
        $table = DB::table($this->getTable());
        $deleteStatement->setTable($table);
        $where = DB::where($table->getColumn('PK'), DB::intTerm((int) $this->PK));
        $deleteStatement->setWhere($where);
        $deleteStatement->insertDatabase();
    }

    public function findSingleConnection($lkLeft, $lkRight)
    {
        $table = DB::table($this->getTable());
        $where = DB::where($table->getColumn('lkLeft'), DB::intTerm($lkLeft));
        $where->addAnd($table->getColumn('lkRight'), DB::intTerm($lkRight));
        $selectStatement = new base_database_statement_Select();
        $selectStatement->setTable($table);
        $selectStatement->setWhere($where);
        $result = $selectStatement->fetchDatabase();
        if (count($result) > 1) {
            Logger::output('BaseConnectionObject.log', "Duplicated entry for '" . get_class($this) . "' with lkLeft '$lkLeft' and lkRight '$lkRight'");
        }
        if (count($result) == 0) {
            return null;
        }
        $this->_setObject($result);
        return $this;
    }
}