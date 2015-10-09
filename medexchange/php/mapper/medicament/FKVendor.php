<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 16.03.2015
 * Time: 13:03
 */

class medexchange_mapper_medicament_FKVendor extends base_mapper_BaseObject
{
   public function mapFieldValue($value)
   {
       $obj = Factory::createObject('vendor');
       $table = DB::table($obj->getTable());
       $where = DB::where($table->getColumn('name'), DB::term($value));
       $finder = Finder::create('vendor')->setWhere($where);
       $result = $finder->find(array($table->getColumn('LK')));
       if (count($result) > 1) {
           throw new base_exception_Mapper(TMS('medexchange.exception.mapper.vendorDuplicatedEntry'));
       }
       $lkArray = $result[0];
       return $lkArray['LK'];
   }

}