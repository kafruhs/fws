<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.10.2014
 * Time: 12:32
 */

abstract class Controller
{
    const CALLER_SECTION_MAIN = 1;

    const CALLER_SECTION_ACP = 2;

    /**
     * @var View
     */
    protected $view;


    /**
     * @var Model
     */
    protected $model;

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
     * @return int
     */
    public function getCallerSection()
    {
        return $this->callerSection;
    }

    /**
     * @var RequestHelper
     */
    protected $requestHelper;

    public function __construct($caller = self::CALLER_SECTION_MAIN)
    {
        $this->setCallerSection($caller);
        $this->_instanciateRequestHelper();
        $this->_instanciateView();
        $this->_instanciateModel();
    }

    private final function _instanciateRequestHelper()
    {
        $this->requestHelper = new RequestHelper();
    }

    private final function _instanciateModel()
    {
        $this->model = $this->getModel();
    }

    private final function _instanciateView()
    {
        $this->view = $this->getView();
    }

    /**
     * @return View
     */
    abstract public function getView();

    /**
     * @param OutputDevice $od
     */
    public function display(OutputDevice $od)
    {
        $this->view->display($od);
    }

    /**
     * get the title of the page
     *
     * @return string
     */
    public function getPageTitle()
    {
        return $this->view->getPageTitle();
    }

    /**
     * get the description of the page
     *
     * @return string
     */
    public function getPageDescription()
    {
        return $this->view->getPageDescription();
    }

    /**
     * @return Model
     */
    abstract public function getModel();

    /**
     * get the actual requestHelper
     *
     * @return RequestHelper
     */
    public function getRequestHelper()
    {
        return $this->requestHelper;
    }

    public function getModelData()
    {
        return $this->model->getData();
    }

    /**
     * validate RequestParams
     */
    public function validateParams()
    {

    }
} 