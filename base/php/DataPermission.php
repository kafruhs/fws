<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 10.06.2015
 * Time: 15:55
 */

abstract class DataPermission
{
    protected $table = 'datapermission';
    /**
     * @var array   assigned users
     */
    protected $users= [];

    /**
     * array    assigned groups
     */
    protected $groups = [];

    /**
     * @param BaseObject $obj
     */
    protected function __construct(BaseObject $obj)
    {
        $this->setOccupants($obj);
    }


    /**
     * set occupants
     *
     * @param BaseObject $obj
     * @return mixed
     */
    abstract protected function setOccupants(BaseObject $obj);

    /**
     * get all occupants
     *
     * @return array
     */
    public function getOccupants()
    {
        $occupants = [
            'user' => $this->users,
            'group' => $this->groups
        ];
        return $occupants;
    }

    /**
     * is the given userlk part of this occupants list
     *
     * @param $userLK
     * @return bool
     */
    public function isUserOccupant($userLK)
    {
        if (in_array($userLK, $this->users)) {
            return true;
        }

        $connObj = new ConnUserGroup();
        foreach ($this->groups as $groupLK) {
            $connObj->findSingleConnection($userLK, $groupLK);
            if (!is_null($connObj)) {
                return true;
            }
        }
        return false;
    }

    /**
     * get a new instance of the given className
     *
     * @param $className
     * @return DataPermission
     * @throws BaseException
     */
    public static function createObject(BaseObject $obj)
    {
        $objClass = get_class($obj);
        $className = self::_loadDataPermissionClass($objClass);
        $className = "base_datapermission_$className";
        $dPObj = new $className($obj);
        if (!$dPObj instanceof DataPermission) {
            throw new base_exception_DataPermission(TMS(base_exception_DataPermission::FACTORY_NO_INSTANCE_OF_DP));
        }
        return $dPObj;
    }

    private static function _loadDataPermissionClass($className)
    {
        $table = DB::table('datapermission');
        $where = DB::where($table->getColumn('objClass'), DB::term($className));
        $selectStatement = new base_database_statement_Select();
        $selectStatement->setTable($table);
        $selectStatement->setWhere($where);
        $selectStatement->setColumns(array($table->getColumn('dpClass')));
        $result = $selectStatement->fetchDatabase();
        /** @todo tabelle anlegen!!!!! */
        if (count($result) != 1) {
            return ucfirst('nobody');
        }
        return ucfirst($result[0]['dpClass']);

    }
}