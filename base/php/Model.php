<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 15.06.2015
 * Time: 07:09
 */

abstract class Model
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var Controller
     */
    protected $controller;

    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
        $this->setData();
    }

    /**
     * get the data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * set data
     */
    abstract public function setData();

}