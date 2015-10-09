<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.10.2014
 * Time: 13:01
 */

class RequestHelper
{
    /**
     * post variables
     *
     * @var array
     */
    protected $post;

    /**
     * get variables
     *
     * @var array
     */
    protected $get;

    /**
     * request variables
     *
     * @var array
     */
    protected $request;

    /**
     * set the different globals
     */
    public function __construct()
    {
        $this->post     = $_POST;
        $this->get      = $_GET;
        $this->request  = $_REQUEST;
    }

    /**
     * does the given paramName exist?
     *
     * @param $paramName
     * @return bool
     */
    public function hasParam($paramName)
    {
        if (isset($this->request[$paramName])) {
            return true;
        }
        return false;
    }

    /**
     * get the parameter with the given paramName; return null if it does not exist
     *
     * @param $paramName
     * @return null
     */
    public function getParam($paramName)
    {
        if ($this->hasParam($paramName) == false) {
            return null;
        }

        return $this->request[$paramName];
    }

    /**
     * is the given paramName a $_POST-parameter
     *
     * @param $paramName
     * @return bool
     */
    public function isPostParam($paramName)
    {
        if (isset($this->post[$paramName])) {
            return true;
        }
        return false;
    }

    /**
     * is the given paramName a $_GET-parameter
     *
     * @param $paramName
     * @return bool
     */
    public function isGetParam($paramName)
    {
        if (isset($this->get[$paramName])) {
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getAllParams()
    {
        return $this->request;
    }


} 