<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 20.01.2015
 * Time: 08:35
 */

class base_datatype_Lk extends base_datatype_Numeric
{
    public function toExternal($value)
    {
        if (empty($value)) {
            return $value;
        }
        $className = $this->fi->getConnectedClass();
        $obj = Factory::createObject($className);
        $table = DB::table($obj->getTable());
        $where = DB::where($table->getColumn('LK'), DB::intTerm($value));
        $displayField = $this->fi->getFieldsOfConnectedClass();
        $result = Finder::create($className)->setWhere($where)->find(array($table->getColumn($displayField)));
        if (empty($result)) {
            return null;
        }
        return $result[0][$displayField];
    }

    public function getJSColModelElement()
    {
        $colModel = new base_js_ColModelElement();
        $colModel->setName($this->fi->getFieldName())
            ->setIndex($this->fi->getFieldName())
            ->setWidth($this->fi->getDisplayedLength())
            ->setClasses($this->fi->getFieldName());
        return $colModel;
    }

    public function fromDBToExternal($value)
    {
        $obj = Factory::createObject($this->fi->getConnectedClass());
        $select = new base_database_statement_Select();
        $table = DB::table($obj->getTable());
        $where = DB::where($table->getColumn('LK'), DB::intTerm((int) $value));
        $select->setTable($table);
        $select->setWhere($where);
        $select->setColumns(array($table->getColumn($this->fi->getFieldsOfConnectedClass())));
        $result = $select->fetchDatabase();
        $value = current($result);
        return $value[$this->fi->getFieldsOfConnectedClass()];

    }


}