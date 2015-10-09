<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.01.2015
 * Time: 10:35
 */

class base_install_Column
{
    const VARCHAR       = 'VARCHAR';

    const INT           = 'INT';

    const FLOAT         = 'FLOAT';

    const TEXT          = 'TEXT';

    const BOOL          = 'BOOLEAN';

    const DATETIME      = 'DATETIME';

    const AUTOINCREMENT = 'AUTO_INCREMENT';

    const PRIMARYKEY    = 'PRIMARY KEY';

    const NOTNULL       = 'NOT NULL';

    const CURRENT_TIMESTAMP = 'CURRENT_TIMESTAMP';

    protected $name;

    protected $type;

    protected $length;

    protected $isNull = false;

    protected $isPrimary = false;

    protected $isAutoIncrement = false;

    protected $default;

    /**
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param $default
     * @return $this
     */
    public function setDefault($default)
    {
        $this->default = $default;
        return $this;
    }

    /**
     * @return $this
     */
    public function setNull()
    {
        $this->isNull = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function setPrimary()
    {
        $this->isPrimary = true;
        return $this;
    }

    /**
     * @param $length
     * @return $this
     */
    public function setLength($length)
    {
        $this->length = $length;
        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param $type
     * @return $this
     * @throws base_database_Exception
     */
    public function setType($type)
    {
        if (!in_array($type, array(self::INT, self::FLOAT, self::BOOL, self::VARCHAR, self::TEXT, self::DATETIME))) {
            throw new base_database_Exception(TMS(base_database_Exception::NO_VALID_COLTYPE, array('colType' => $type)));
        }
        $this->type = $type;
        return $this;
    }

    /**
     * @return $this
     */
    public function setAutoIncrement()
    {
        $this->isAutoIncrement = true;
        return $this;
    }

    /**
     * @return string
     */
    public function toString()
    {
        $params[] = $this->name;
        $params[] = $this->type;
        if (isset($this->length)) {
            $params[] = '(' . $this->length . ')';
        }
        if ($this->isAutoIncrement) {
            $params[] = self::AUTOINCREMENT;
        }

        if ($this->isPrimary) {
            $params[] = self::PRIMARYKEY;
        }

        if (!$this->isNull) {
            $params[] = self::NOTNULL;
        }

        if ($this->default) {
            if ($this->default == self::CURRENT_TIMESTAMP) {
                $params[] = "DEFAULT {$this->default}";
            } else {
                $params[] = "DEFAULT '{$this->default}'";
            }
        }

        return implode(' ', $params);
    }

}