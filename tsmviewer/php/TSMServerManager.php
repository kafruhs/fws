<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 30.01.2015
 * Time: 08:31
 */

class TSMServerManager implements base_interface_Singleton
{
    static private $_instance = null;

    /**
     * @var int
     */
    protected $actualTsmServerLK;
        /**
     * get a new class instance
     */
    public static function get()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct()
    {

    }

    /**
     * @return int
     */
    public function getActualTsmServerLK()
    {
        return $this->actualTsmServerLK;
    }

    /**
     * @param int $actualTsmServerLK
     */
    public function setActualTsmServerLK($actualTsmServerLK)
    {
        $this->actualTsmServerLK = $actualTsmServerLK;
    }

}