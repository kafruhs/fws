<?php
/**
 * Created by PhpStorm.
 * User: Mediacenter
 * Date: 01.08.2014
 * Time: 15:34
 */

class Configuration implements base_interface_Singleton
{
    protected $configFileName = 'config';

    protected $entries = [];

    private static $_instance = null;

    /**
     * @return Configuration
     */
    public static function get()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct()
    {
        $this->entries = parse_ini_file(ROOT . '/data/' . $this->configFileName);
    }

    public function getEntry($entryName)
    {
        return $this->entries[$entryName];
    }


} 