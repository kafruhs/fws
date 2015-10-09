<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 29.01.2015
 * Time: 13:49
 */

class tsmviewer_mapper_tsmnode_FKdomain extends base_mapper_BaseObject
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
        $obj = Factory::createObject('TSMDomain');
        $table = DB::table($obj->getTable());
        $where = DB::where($table->getColumn('name'), DB::term($value));
        $where->addAnd($table->getColumn('FK_tsmserver'), DB::term(TSMServerManager::get()->getActualTsmServerLK()));
        $finder = Finder::create('TSMDomain')->setWhere($where);
        $result = $finder->find(array($table->getColumn('LK')));

        if (empty($result)) {
            throw new base_exception_Mapper(TMS('tsmviewer.exception.mapper.domainNameNoResult'));
        }

        if (count($result) > 1) {
            throw new base_exception_Mapper(TMS('tsmviewer.exception.mapper.domainNameDuplicatedEntry'));
        }

        $pkArray = current($result);

        return $pkArray['LK'];
    }
}