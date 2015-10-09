<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 15.01.2015
 * Time: 18:27
 */

class Sequence
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var int
     */
    protected $actSeq;

    /**
     * @var int
     */
    protected $nextSeq;

    public function __construct($class)
    {
        Check::classNameInstanceOfBaseObject($class);
        $this->class = $class;
        $this->_load();
    }

    public function getActualSequence()
    {
        return $this->actSeq;
    }

    public function getNextSequence()
    {
        return $this->nextSeq;
    }

    private function _load()
    {
        $table = DB::table('sequence');
        $colNum = $table->getColumn('num');
        $colClass = $table->getColumn('class');
        $statement = new base_database_statement_Select();
        $statement->setColumns(array($colNum));
        $statement->setTable($table);
        $where = DB::where($colClass, DB::term($this->class));
        $statement->setWhere($where);
        $result = $statement->fetchDatabase();
        if (empty($result)) {
            $this->actSeq = 0;
        } else {
            $values = $result[0];
            $this->actSeq = $values['num'];
        }
        $this->nextSeq = $this->actSeq + 1;
    }

    public function save()
    {
        if ($this->getNextSequence() == 1) {
            $this->_insertNewSequence();
        } else {
            $this->_updateExistingSequence();
        }
    }

    private function _insertNewSequence()
    {
        $table = DB::table('sequence');
        $statement = new base_database_statement_Insert();
        $statement->setTable($table);
        $statement->setColumnValue($table->getColumn('class'), DB::term($this->class));
        $statement->setColumnValue($table->getColumn('num'), DB::term($this->nextSeq));
        $statement->insertDatabase();
    }

    private function _updateExistingSequence()
    {
        $table = DB::table('sequence');
        $statement = new base_database_statement_Update();
        $statement->setTable($table);
        $statement->setColumnValue($table->getColumn('num'), DB::term($this->nextSeq));
        $where = DB::where($table->getColumn('class'), DB::term($this->class));
        $statement->setWhere($where);
        $statement->insertDatabase();
    }
}