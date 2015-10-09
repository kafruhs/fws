<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 03.02.2015
 * Time: 14:24
 */

class tsmviewer_mapper_tsmnode_FKcollocgroup extends base_mapper_BaseObject
{
    /**
     * converts a given value to the specified structure
     *
     * @param $value
     * @return mixed
     * @throws base_database_Exception
     * @throws base_exception_Mapper
     */
    public function mapFieldValue($value)
    {
        $obj = Factory::createObject('TSMCollocgroup');
        $table = DB::table($obj->getTable());
        $where = DB::where($table->getColumn('name'), DB::term($value));
        $where->addAnd($table->getColumn('FK_tsmserver'), DB::term(TSMServerManager::get()->getActualTsmServerLK()));
        $finder = Finder::create('TSMCollocgroup')->setWhere($where);
        $result = $finder->find(array($table->getColumn('LK')));

        if (count($result) > 1) {
            throw new base_exception_Mapper(TMS('tsmviewer.exception.mapper.collocgroupDuplicatedEntry'));
        }

        $lkArray = current($result);

        return $lkArray['LK'];
    }
}