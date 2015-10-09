<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.01.2015
 * Time: 21:04
 */

class base_importer_csv_TMSImporter extends base_importer_CSV
{
    /**
     */
    protected function getWhereForExistingData(array $data)
    {
        $columnPK     = $this->table->getColumn('name');
        $where = DB::where($columnPK, DB::stringTerm($data['name']));
        return $where;
    }
}