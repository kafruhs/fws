<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 08.07.2015
 * Time: 07:38
 */

class SelectionListEntry
{
    protected $table = 'selectionListEntry';

    protected $PK;

    protected $name;

    protected $FK_selectionList;

    /**
     * @return mixed
     */
    public function getPK()
    {
        return $this->PK;
    }

    /**
     * @param mixed $PK
     */
    public function setPK($PK)
    {
        $this->PK = $PK;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getFKSelectionList()
    {
        return $this->FK_selectionList;
    }

    /**
     * @param mixed $FK_selectionList
     */
    public function setFKSelectionList($FK_selectionList)
    {
        $this->FK_selectionList = $FK_selectionList;
    }

    public function setProperty($propName, $value)
    {
        $this->$propName = $value;
    }

    /**
     * get all selectionlist entries for a given selectionlist PK
     *
     * @param $FK_selectionList
     * @return SelectionListEntry[]
     */
    public static function loadAllSelectionListEntries($FK_selectionList)
    {
        $table = DB::table('selectionListEntry');
        $where = DB::where($table->getColumn('FK_selectionList'), DB::intTerm($FK_selectionList));
        $select = new base_database_statement_Select();
        $select->setTable($table);
        $select->setWhere($where);
        $result = $select->fetchDatabase();
        $selectionListEntries = [];
        foreach ($result as $row) {
            $selectionListEntry = new self();
            foreach ($row as $propName => $value) {
                $selectionListEntry->setProperty($propName, $value);
            }
            $selectionListEntries[] = $selectionListEntry;
        }
        return $selectionListEntries;
    }
}