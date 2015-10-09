<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.09.2014
 * Time: 14:29
 */

class Finder
{

    /**
     * @var string
     */
    protected $className;

    /**
     * @var base_database_Table
     */
    protected $table;

    /**
     * @var base_database_Where
     */
    protected $where = null;

    /**
     * @var base_database_Order
     */
    protected $order = null;

    /**
     * @var base_database_Limit
     */
    protected $limit = null;

    /**
     * create a new Finder for the given class
     *
     * @param string $className
     * @return Finder
     */
    public static function create($className)
    {
        return new self($className);
    }

    /**
     * @param string $className
     */
    protected function __construct($className)
    {
        $obj = Factory::createObject($className);
        $this->class = $className;
        $this->table = DB::table($obj->getTable());
    }

    /**
     * set a where condition
     *
     * @param base_database_Where $where
     * @return $this
     */
    public function setWhere(base_database_Where $where)
    {
        $this->where = $where;
        return $this;
    }

    /**
     * set the order
     *
     * @param base_database_Order $order
     * @return $this
     */
    public function setOrder(base_database_Order $order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * set the limits
     *
     * @param base_database_Limit $limit
     * @return $this
     */
    public function setlimit(base_database_Limit $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * find with defined conditions, order, etc.
     *
     * @param base_database_Column[] $columns
     * @return BaseObject[]|array
     */
    public function find($columns = array(), $historic = false)
    {
        $loadObjects = false;
        if (empty($columns) === true) {
            $columns = array($this->table->getColumn('LK'));
            $loadObjects = true;
        }

        if ($historic == false) {
            if (empty($this->where)) {
                $this->where = DB::where($this->table->getColumn('histtop'), DB::term('Y'));
            } else {
                $this->where->addAnd($this->table->getColumn('histtop'), DB::term('Y'));
            }
        }

        if (empty($this->order)) {
            $this->order = new base_database_Order($this->table->getColumn('LK'), base_database_Order::ASC);
        }

        $select = $this->_createSelectStatement($columns);
        $result = $select->fetchDatabase();

        if ($loadObjects === true) {
            $lks = $this->_getLKList($result);
            $result = $this->_createObjectList($lks);
        }

        return $result;
    }

    public function count($historic = false)
    {
        $columns = array($this->table->getColumn('LK'));

        if ($historic == false) {
            if (empty($this->where)) {
                $this->where = DB::where($this->table->getColumn('histtop'), DB::term('Y'));
            } else {
                $this->where->addAnd($this->table->getColumn('histtop'), DB::term('Y'));
            }
        }

        if (empty($this->order)) {
            $this->order = new base_database_Order($this->table->getColumn('LK'), base_database_Order::ASC);
        }

        $select = $this->_createSelectStatement($columns);
        $result = $select->fetchDatabase();

        return count($result);
    }

    /**
     * create an array with objects of the given class
     *
     * @param $lks
     * @return array
     */
    private function _createObjectList($lks)
    {
        $obj = [];
        foreach ($lks as $lk) {
            $obj[] = Factory::loadObject($this->class, $lk);
        }

        return $obj;
    }

    /**
     * create the select statement
     *
     * @param $columns
     * @return base_database_statement_Select
     */
    private function _createSelectStatement($columns)
    {
        $select = new base_database_statement_Select();
        $select->setTable($this->table);
        $select->setColumns($columns);
        if (!empty($this->order)) {
            $select->setOrder($this->order);
        }

        if (!empty($this->limit)) {
            $select->setLimit($this->limit);
        }

        if (!empty($this->where)) {
            $select->setWhere($this->where);
        }

        return $select;
    }

    /**
     * create a list with LKs
     *
     * @param $result
     * @return array
     */
    private function _getLKList($result)
    {
        $lks = [];
        foreach ($result as $row) {
            $lks[] = (int) $row['LK'];
        }
        return $lks;
    }


}