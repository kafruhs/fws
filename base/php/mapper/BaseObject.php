<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 29.01.2015
 * Time: 11:27
 */

abstract class base_mapper_BaseObject
{
    /**
     * @var array
     */
    protected $currentDataSet;

    public function _construct($currentDataSet)
    {
        $this->currentDataSet = $currentDataSet;
    }

    /**
     * @return BaseObject
     */
    public function getCurrentDataSet()
    {
        return $this->currentDataSet;
    }

    /**
     * @param array $currentDataSet
     * @return $this
     */
    public function setCurrentDataSet($currentDataSet)
    {
        $this->currentDataSet = $currentDataSet;
        return $this;
    }

    /**
     * converts a given value to the specified structure
     *
     * @param $value
     * @return mixed
     */
    abstract public function mapFieldValue($value);
}