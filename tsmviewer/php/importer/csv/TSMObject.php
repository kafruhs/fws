<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 03.02.2015
 * Time: 10:35
 */

class tsmviewer_importer_csv_TSMObject extends base_importer_csv_BaseObject
{
    /**
     */
    protected function addValuesToData(array $data)
    {
        $data['FK_tsmserver'] = TSMServerManager::get()->getActualTsmServerLK();
        return $data;
    }

    /**
     *
     *
     * @param array $data
     * @return base_database_Where|null
     * @throws base_database_Exception
     */
    protected function getWhereForFindExistingData(array $data)
    {
        if (!isset($data['name']) || !isset($data['FK_tsmserver'])) {
            return null;
        }
        $table = DB::table($this->obj->getTable());
        $column = $table->getColumn('name');
        $where = DB::where($column, DB::term($data['name']));
        $where->addAnd($table->getColumn('FK_tsmserver'), DB::intTerm($data['FK_tsmserver']));
        $where->addAnd($table->getColumn('histtop'), DB::term('Y'));
        return $where;
    }


}