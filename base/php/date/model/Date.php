<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23.10.2014
 * Time: 22:47
 */

class base_date_model_Date
{
    /**
     * @var DateTime
     */
    protected $dateTimeObj;

    /**
     * store hte given DateTime object or create a new one with actual time
     *
     * @param DateTime $dateTimeObj
     */
    public function __construct(DateTime $dateTimeObj = null)
    {
        if (is_null($dateTimeObj)) {
            $dateTimeObj = new DateTime();
        }

        $this->dateTimeObj = $dateTimeObj;
    }

    /**
     * get the year of the actual set DateTimeObject
     *
     * @return bool|string
     */
    public function getDay()
    {
        return $this->dateTimeObj->format('d');
    }

    /**
     * get the month of the actual set DateTimeObject
     *
     * @return bool|string
     */
    public function getMonth()
    {
        return $this->dateTimeObj->format('m');
    }

    /**
     * get the day of the actual set DateTimeObject
     *
     * @return bool|string
     */
    public function getYear()
    {
        return $this->dateTimeObj->format('Y');
    }

    /**
     * return the number of the quartal for the given DateTime
     *
     * @return int
     */
    public function getQuartal()
    {
        $mounthNumber = $this->dateTimeObj->format('n');;
        if ($mounthNumber < 4) {
            return 1;
        }

        if ($mounthNumber < 7) {
            return 2;
        }

        if ($mounthNumber < 10) {
            return 3;
        }

        return 4;
    }
}