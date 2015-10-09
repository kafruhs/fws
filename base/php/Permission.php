<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.03.2015
 * Time: 17:54
 */

class Permission extends BaseObject
{
    const BENUTZER = 'Benutzer';

    const MODERATOR = 'Moderator';

    const ADMINISTRATOR = 'Administrator';

    const EVERYBODY = 'Jeder';

    protected $table = 'permission';

    protected $writePermission = self::ADMINISTRATOR;

    protected $deletePermission = self::ADMINISTRATOR;

    protected $stdSearchColumns = array('name');

    /**
     * load the right object by its LK
     *
     * @param $lk
     * @return mixed|null
     * @throws base_database_Exception
     */
    public static function getPermissionNameByLK($lk)
    {
        $table = DB::table('permission');
        $column = $table->getColumn('LK');
        $where = DB::where($column, DB::term($lk));
        $finder = Finder::create('permission')->setWhere($where);
        $results = $finder->find(array($table->getColumn('name')));
        if (empty($results)) {
            return null;
        }
        $result = $results[0];
        return $result['name'];
    }

    /**
     * load the right object by its name
     *
     * @param $name
     * @return mixed|null
     * @throws base_database_Exception
     */
    public static function getPermissionLKByName($name)
    {
        $table = DB::table('permission');
        $column = $table->getColumn('name');
        $where = DB::where($column, DB::term($name));
        $finder = Finder::create('permission')->setWhere($where);
        $results = $finder->find(array($table->getColumn('LK')));
        if (empty($results)) {
            return null;
        }
        $result = $results[0];
        return $result['LK'];
    }

    public function getDisplayName()
    {
        return "Recht";
    }
}