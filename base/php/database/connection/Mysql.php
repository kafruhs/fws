<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.08.2014
 * Time: 08:38
 */

class base_database_connection_Mysql implements base_interface_Singleton
{
    /**
     * hostname of the db
     *
     * @var string
     */
    protected $dbHost;

    /**
     * user for connecting to the db
     *
     * @var string
     */
    protected $dbUser;

    /**
     * password for connecting to the db
     *
     * @var string
     */
    protected $dbPassword;

    /**
     * name of the db
     *
     * @var string
     */
    protected $dbName;

    /**
     * PDO db connection object
     *
     * @var PDO
     */
    protected $pdo;

    /**
     * contains errors from executing db statements
     *
     * @var array
     */
    protected $errors = [];

    /**
     * @var base_database_connection_Mysql
     */
    private static $_instance = null;

    /**
     * @return base_database_connection_Mysql
     */
    public static function get()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * @throws base_database_Exception
     */
    private function __construct()
    {
        $this->dbHost = Configuration::get()->getEntry('dbHost');
        $this->dbName = Configuration::get()->getEntry('dbName');
        $this->dbUser = Configuration::get()->getEntry('dbUser');
        $this->dbPassword = Configuration::get()->getEntry('dbPassword');
        try {
            $this->pdo = new PDO("mysql:host={$this->dbHost};dbname={$this->dbName}", $this->dbUser, $this->dbPassword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            throw new base_database_Exception(TMS(base_database_Exception::DB_CONNECTION_NOT_POSSIBLE));
        }
    }

    /**
     *begin a new transaction; throws exception if a transaction was already started
     *
     * @throws base_database_Exception
     */
    public function beginTransaction()
    {
        try {
            $this->pdo->beginTransaction();
        } catch (Exception $e) {
            throw new base_database_Exception(TMS(base_database_Exception::DB_TRANSACTION_ALREADY_STARTED));
        }
    }

    /**
     * commit the transaction; in case of errors performs a rollback
     */
    public function endTransaction()
    {
        $this->inTransaction();
        if ($this->hasErrors() === true) {
            $this->doRollback();
        } else {
            $this->doCommit();
        }
    }

    /**
     * execute a statement like inserts, updates, etc.
     *
     * @param base_database_interface_SetStatement $statement
     * @throws base_database_Exception
     * @return int
     */
    public function execute(base_database_interface_SetStatement $statement)
    {
        $this->inTransaction();
        try {
            $lastID = $this->pdo->exec($statement->toString());
        } catch (Exception $e) {
            $this->errors[] = $e->getMessage();
            $lastID = null;
        }
        return $lastID;
    }

    /**
     * fetch data from database
     *
     * @param base_database_interface_GetStatement $statement
     * @throws base_database_Exception
     * @return array
     */
    public function query(base_database_interface_GetStatement $statement)
    {
        try {
            $query = $this->pdo->query($statement->toString());
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new base_database_Exception(TMS(base_database_Exception::DB_QUERY_FAILED, array('statement' => $statement->toString())));
        }
        foreach ($result as &$row) {
            foreach ($row as $fieldName => $value) {
                if (ctype_digit($value)) {
                    $row[$fieldName] = intval($value);
                }
            }
        }
        return $result;
    }


    /**
     * are there errors from executing statements
     *
     * @return int
     */
    public function hasErrors()
    {
        return count($this->errors) > 0;
    }

    /**
     * performs the rollback
     *
     * @throws base_database_Exception
     */
    public function doRollback()
    {
        try {
            $this->pdo->rollBack();
        } catch (Exception $e) {
            throw new base_database_Exception($e->getMessage());
        }
        throw new base_database_Exception(implode(', ', $this->errors));
    }

    /**
     * performs the commit
     *
     * @throws base_database_Exception
     */
    public function doCommit()
    {
        try {
            $this->pdo->commit();
        } catch (Exception $e) {
            throw new base_database_Exception(TMS(base_database_Exception::DB_COMMIT_FAILED));
        }
    }

    public function inTransaction()
    {
        try {
            $inTransaction = $this->pdo->inTransaction();
        } catch (Exception $e) {
            throw new base_database_Exception(TMS(base_database_Exception::DB_TRANSACTION_NOT_ACTIVE));
        }

        if ($inTransaction === false) {
            throw new base_database_Exception(TMS(base_database_Exception::DB_TRANSACTION_NOT_ACTIVE));
        }
    }
}