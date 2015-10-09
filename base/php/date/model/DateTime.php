<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23.10.2014
 * Time: 23:03
 */

class base_date_model_DateTime extends base_date_model_Date
{
    /**
     * get the hour of the actual set DateTimeObject
     *
     * @return bool|string
     */
    public function getHour()
    {
        return $this->dateTimeObj->format('H');
    }

    /**
     * get the minutes of the actual set DateTimeObject
     *
     * @return bool|string
     */
    public function getMinute()
    {
        return $this->dateTimeObj->format('i');
    }

    /**
     * get the seconds of the actual set DateTimeObject
     *
     * @return string
     */
    public function getSeconds()
    {
        return $this->dateTimeObj->format('s');
    }

    /**
     * @param string $format
     * @return string
     */
    public function display($format = 'd.m.Y H:i')
    {
        return $this->dateTimeObj->format($format);
    }

    public function toDB()
    {
        return $this->dateTimeObj->format('Y-m-d H:i:s');
    }
} 