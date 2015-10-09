<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.12.2014
 * Time: 18:11
 */

class base_importer_csv_Fieldinfo extends base_importer_CSV
{
    /**
     */
    protected function getWhereForExistingData(array $data)
    {
        $columnClass     = $this->table->getColumn('class');
        $columnFieldName = $this->table->getColumn('fieldName');
        $where = DB::where($columnClass, DB::stringTerm($data['class']));
        $where->addAnd($columnFieldName, DB::stringTerm($data['fieldName']));
        return $where;
    }
}