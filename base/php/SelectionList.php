<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 08.07.2015
 * Time: 07:17
 */

class SelectionList
{
    protected $table = 'selectionList';

    /**
     * @var SelectionListEntry[]
     */
    protected $entries;

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $PK;

    /**
     * @param $identifier
     * @throws base_exception_SelectionList
     */
    public function load($identifier)
    {
        $table = DB::table($this->table);
        $where = DB::where($table->getColumn('identifier'), DB::stringTerm($identifier));
        $select = new base_database_statement_Select();
        $select->setTable($table);
        $select->setWhere($where);
        $result = $select->fetchDatabase();
        if (count($result) > 1) {
            throw new base_exception_SelectionList(TMS(base_exception_SelectionList::DUPLICATED_IDENTIFIER));
        }
        if (!empty($result)) {
            foreach ($result[0] as $propName => $value) {
                $this->$propName = $value;
            }
            $this->_loadEntries();
        }
    }

    private function _loadEntries()
    {
        $this->entries = SelectionListEntry::loadAllSelectionListEntries($this->PK);
    }
}