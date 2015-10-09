<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.02.2015
 * Time: 07:16
 */

abstract class base_cmd_Controller
{
    /**
     * @var array
     */
    protected $params = array();

    /**
     * @var base_cmd_Model
     */
    protected $model;

    /**
     * @throws base_exception_CMD
     */
    public function __construct()
    {
        if (!isset($GLOBALS['argv'])) {
            throw new base_exception_CMD(TMS(base_exception_CMD::NO_CMD_CALL));
        }
        $this->setParams();
        $this->model = $this->getModel();
    }

    /**
     * get the model according to the controller
     *
     * @return base_cmd_Model
     */
    abstract protected function getModel();

    /**
     * execute the given cmd request
     */
    public function executeRequest()
    {
        $this->model->execute();
    }

    /**
     * get all params, validate them and  store them to the params array
     */
    protected function setParams()
    {
        $args = array_merge($GLOBALS['argv'], $GLOBALS['argc']);
        $this->validateParams($args);
        $this->params = $args;
    }

    /**
     * vaidation of the argv and argc parameter
     *
     * @param array $args
     */
    protected function validateParams(array $args)
    {
        return;
    }
}