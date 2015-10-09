<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 17.08.2014
 * Time: 17:01
 */

class base_database_Column
{
    const PRIMARY_KEY = 'PRI';

    const AUTO_INCREMENT = 'auto_increment';

    const NOT_NULL = 'NO';

    protected $name;

    protected $type;

    protected $length;

    protected $isNull = false;

    protected $isPrimary = false;

    protected $isAutoIncrement = false;

    protected $default;

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param mixed $default
     */
    public function setDefault($default)
    {
        $this->default = $default;
    }

    /**
     * @return boolean
     */
    public function isNull()
    {
        return $this->isNull;
    }

    /**
     * @param boolean $isNull
     */
    public function setNull()
    {
        $this->isNull = true;
    }

    /**
     * @return boolean
     */
    public function isPrimary()
    {
        return $this->isPrimary;
    }

    /**
     * @param boolean $isPrimary
     */
    public function setPrimary()
    {
        $this->isPrimary = true;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param mixed $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isAutoIncrement()
    {
        return $this->isAutoIncrement();
    }

    /**
     *
     */
    public function setAutoIncrement()
    {
        $this->isAutoIncrement = true;
    }


} 