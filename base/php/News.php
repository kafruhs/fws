<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 16.07.2015
 * Time: 15:21
 */

class News extends BaseObject
{
    protected $table = 'news';

    /**
     * @var string  Permission needed to read objects of this class
     */
    protected $readPermission = Permission::EVERYBODY;

    /**
     * @var string  Permission needed to add a new object of this class
     */
    protected $writePermission = Permission::ADMINISTRATOR;

    /**
     * @var string  Permission needed to delete an object of this class
     */
    protected $deletePermission = Permission::ADMINISTRATOR;

    /**
     * columns, that will be displayed in searchresults, if not different specified in url
     *
     * @var array
     */
    protected $stdSearchColumns = array('title', 'content');


}