<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 31.08.2014
 * Time: 22:00
 */

class TMS
{
    /**
     * @var string  text module
     */
    protected $module;

    /**
     * @var string
     */
    protected $value;

    /**
     * @param string $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * get the value string
     *
     * @return string
     */
    public function getValue($mappings = array())
    {
        if (count($mappings) > 0) {
            $this->_templateValue($mappings);
        }

        return $this->value;
    }

    /**
     * load the TMS by its module name
     *
     * @throws base_exception_TMS
     */
    public function load()
    {
        if (empty($this->module) === true) {
            throw new base_exception_TMS(base_exception_TMS::NO_MODULE_SELECTED);
        }

        $select = $this->_setSelectStatement();
        $result = $select->fetchDatabase();
        $result = $this->_validateResult($result);
        if (is_null($result) === true) {
            $this->value = $this->module;
        } else {
            $this->value = $result[Language::get()->getSelectedLanguage()];
        }
    }

    /**
     * validate the database entries
     *
     * @param $result
     * @throws base_exception_TMS
     */
    private function _validateResult($result)
    {
        $numberOfDBEntries = count($result);
        if ($numberOfDBEntries > 1) {
            throw new base_exception_TMS(base_exception_TMS::DUPLICATED_ENTRY);
        }

        if ($numberOfDBEntries < 1) {
            return null;
        }

        return $result[0];
    }

    /**
     * set the select statement for the db fetch
     *
     * @return base_database_statement_Select
     * @throws base_database_Exception
     */
    private function _setSelectStatement()
    {
        $table = DB::table('tms');
        $colName = $table->getColumn('name');
        $colValue = $table->getColumn(Language::get()->getSelectedLanguage());
        $where = DB::where($colName, DB::stringTerm($this->module));

        $select = new base_database_statement_Select();
        $select->setTable($table);
        $select->setColumns(array($colValue));
        $select->setWhere($where);
        return $select;
    }

    /**
     * replace placeholders with its values
     *
     * @param $mappings
     */
    private function _templateValue($mappings)
    {
        foreach ($mappings as $key => $value) {
            $this->value = str_replace('${' . $key . '}', $value, $this->value);
        }
    }


} 