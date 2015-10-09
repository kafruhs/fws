<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.03.2015
 * Time: 17:50
 */

class Group extends BaseObject
{
    const BENUTZER = 'Benutzer';

    const MODERATOR = 'Moderator';

    const ADMINISTRATOR = 'Administrator';

    protected $table = 'gruppe';

    protected $mnFields = array('permissions');

    protected $stdSearchColumns = array('LK', 'name', 'permissions');

    public function getDisplayName()
    {
        return 'Gruppe';
    }


    /**
     * load the right object by its LK
     *
     * @param $lk
     * @return mixed|null
     * @throws base_database_Exception
     */
    public static function getGroupNameByLK($lk)
    {
        $table = DB::table('gruppe');
        $column = $table->getColumn('LK');
        $where = DB::where($column, DB::term($lk));
        $finder = Finder::create('group')->setWhere($where);
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
    public static function getGroupLKByName($name)
    {
        $table = DB::table('gruppe');
        $column = $table->getColumn('name');
        $where = DB::where($column, DB::term($name));
        $finder = Finder::create('group')->setWhere($where);
        $results = $finder->find(array($table->getColumn('LK')));
        if (empty($results)) {
            return null;
        }
        $result = $results[0];
        return $result['LK'];
    }
}