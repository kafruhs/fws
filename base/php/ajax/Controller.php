<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 16.12.2014
 * Time: 15:04
 */

abstract class base_ajax_Controller
{
    const ERROR_CONTROLLER_NOT_FOUND = 'base.ajax.controllerNotFound';

    const CALLER_SECTION_MAIN = 1;

    const CALLER_SECTION_ACP = 2;

    /**
     * @var RequestHelper
     */
    protected $requestHelper;

    /**
     * @var string
     */
    protected $callerSection = self::CALLER_SECTION_MAIN;

    /**
     * set the calling section
     *
     * @param $caller
     */
    public function setCallerSection($caller)
    {
        if (!in_array($caller, [self::CALLER_SECTION_MAIN, self::CALLER_SECTION_ACP])) {
            $caller = self::CALLER_SECTION_MAIN;
        }
        $this->callerSection = $caller;
    }

    /**
     * @return string
     */
    public function getCallerSection()
    {
        return $this->callerSection;
    }

    /**
     * @return RequestHelper
     */
    public function getRequestHelper()
    {
        return $this->requestHelper;
    }

    /**
     * @var base_ajax_Model
     */
    protected $model;

    /**
     * @param RequestHelper $requestHelper
     */
    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
        $this->model = $this->getModel();
    }

    /**
     * get the model according to the controller
     *
     * @return base_ajax_Model
     */
    abstract protected function getModel();

    /**
     * execute the given ajax request
     */
    public function executeRequest()
    {
        $this->model->execute();
    }

    public function response($code, $message, $href = '') {
        $obj = new stdClass();
        $obj->code = $code;
        $obj->message = $message;
        $obj->href = $href;
        $json = json_encode($obj);
        echo $json;
    }

}