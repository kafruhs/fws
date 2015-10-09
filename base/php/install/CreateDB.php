<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.01.2015
 * Time: 09:29
 */

class base_install_CreateDB implements base_database_interface_SetStatement
{
    /**
     * @var string
     */
    protected $dbName;

    /**
     * @param string $dbName
     * @throws base_database_Exception
     */
    public function __construct($dbName = '')
    {
        if (empty($dbName)) {
            $dbName = Configuration::get()->getEntry('dbName');
        }

        if (empty($dbName)) {
            throw new base_database_Exception(TMS(base_database_Exception::DB_DBNAME_MISSED));
        }

        $this->dbName = $dbName;
    }

    public function toString()
    {
        return "CREATE DATABASE {$this->dbName} CHARACTER SET utf8 COLLATE utf8_general_ci";
    }

    /**
     * insert result into database
     *
     * @return int
     */
    public function insertDatabase()
    {
        $configuration = Configuration::get();
        $pdo   = new PDO("mysql:host={$configuration->getEntry('dbHost')}", $configuration->getEntry('dbUser'), $configuration->getEntry('dbPassword'));
//        $pdo->exec("DROP DATABASE IF EXISTS {$this->dbName}");
        $pdo->exec($this->toString());
    }
}