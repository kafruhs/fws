<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 16.07.2015
 * Time: 15:32
 */

class base_pages_news_Model extends Model
{
    /**
     * set data
     */
    public function setData()
    {
        $obj = Factory::createObject('News');
        $table = DB::table($obj->getTable());
        $limit = new base_database_Limit(10);
        $order = DB::order($table->getColumn('firstEditTime'));
        $finder = Finder::create('news')->setOrder($order)->setlimit($limit);
        $this->data = $finder->find();
    }

}