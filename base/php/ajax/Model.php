<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 16.12.2014
 * Time: 15:04
 */

abstract class base_ajax_Model
{
    const PROCEED_TO_NEXT_PAGE = 1;

    const STAY_ON_ACTUAL_PAGE = 2;

    const ERROR_MODEL_NOT_FOUND = 'base.ajax.modelNotFound';

    /**
     * @var base_ajax_Controller
     */
    protected $controller;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $msg;

    /**
     * @var int
     */
    protected  $returnCode= self::STAY_ON_ACTUAL_PAGE;

    /**
     * @var string
     */
    protected $redirectUrl;

    public function __construct(base_ajax_Controller $controller)
    {
        $this->controller = $controller;
        $this->_setData();
    }

    private function _setData()
    {
        $requestHelper = $this->controller->getRequestHelper();
        $this->data = $requestHelper->getAllParams();
    }

    /**
     * set the message to be sent on success
     *
     * @var string use TMS
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    /**
     * set the url for redirection after succeeded ajax request
     */
    public function setRedirectUrl($url)
    {
        $this->redirectUrl = HTML_ROOT . '/' . $url;
    }

    /**
     * @return bool
     */
    abstract protected function isExecuteable();

    /**
     * execute the actual ajax request
     */
    abstract protected function executeRequest();

    /**
     * send back json_object with message, url an code
     */
    public function response()
    {
//        if ($this->returnCode == self::PROCEED_TO_NEXT_PAGE) {
        if (strpos($this->redirectUrl, '?')) {
            $getParamSeparator = '&';
        } else {
            $getParamSeparator = '?';
        }
        $redirectUrl = $this->redirectUrl . $getParamSeparator . 'ajaxMsg=' . urlencode($this->msg);
        $this->controller->response($this->returnCode, $this->msg, $redirectUrl);
//            return;
//        }
//        $this->controller->response($this->returnCode, TMS($this->msg));
    }

    /**
     *
     */
    public function execute()
    {
        ob_start();
        if ($this->isExecuteable() === true) {
            try {
                $this->executeRequest();
            } catch (Exception $e) {
//                $this->msg = $e->getMessage();
                Logger::output('protocol.log', $e->getMessage(). $this->msg);
            }
        }
//        $obGetContents = ob_get_contents();
//        if (!empty($obGetContents)) {
//            $this->msg .= ' ' . $obGetContents;
//        }
        ob_clean();
        $this->response();
    }
}