<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 06.02.2015
 * Time: 15:53
 */

class tsmviewer_importer_csv_TSMSummary extends tsmviewer_importer_csv_TSMObject
{
    protected function isIrrelevantData(array $data)
    {
        if (strpos($data['nodeName'], 'FULLVM') && empty($data['subEntity'])) {
            return true;
        }
        return false;
    }

    protected function getWhereForFindExistingData(array $data)
    {
        if (!isset($data['nodeName']) || !isset($data['startTime']) || !isset($data['subEntity'])) {
            return null;
        }
        $table = DB::table($this->obj->getTable());
        $nameCol = $table->getColumn('nodeName');
        $startTimeCol = $table->getColumn('startTime');
        $where = DB::where($nameCol, DB::term($data['nodeName']));
        $date = new base_date_model_DateTime(new DateTime($data['startTime']));
        $where->addAnd($startTimeCol, DB::term($date->toDB()));
        if (!empty($data['subEntity'])) {
            $subEntityCol = $table->getColumn('subEntity');
            $where->addAnd($subEntityCol, DB::term($data['subEntity']));
        }
        $where->addAnd($table->getColumn('FK_tsmserver'), DB::intTerm($data['FK_tsmserver']));
        $where->addAnd($table->getColumn('histtop'), DB::term('Y'));
        return $where;
    }

}