<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04.11.2014
 * Time: 20:24
 */

class base_ui_site_Link
{
    /**
     * @var string  Name of the Page under the directory "de"/"en"
     */
    protected $pageName = 'frontend';

    /**
     * @var
     */
    protected $controllerName;

    /**
     * @var array
     */
    protected $getParams = array();

    /**
     * @var string
     */
    protected $displayName;

    /**
     * @return string
     */
    public function getPageName()
    {
        return $this->pageName;
    }

    /**
     * @param mixed $path
     */
    public function setPageName($path)
    {
        $this->pageName = $path;
    }

    /**
     * @return string
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * @param string $name
     */
    public function setControllerName($name)
    {
        $this->controllerName = $name;
    }

    /**
     * @return array
     */
    public function getGetParams()
    {
        return $this->getParams;
    }

    /**
     * @param array $nameValuePairs
     */
    public function setGetParams($nameValuePairs)
    {
        $this->getParams = $nameValuePairs;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * get the url
     *
     * @return string
     * @throws base_ui_model_Exception
     */
    public function getLinkString()
    {
        $pageName = $this->getPageName();
        $controllerName = $this->getControllerName();
        if ($pageName == 'frontend' && empty($controllerName)) {
            throw new base_ui_model_Exception(TMS(base_ui_model_Exception::LINK_CONTROLLERNAME_NEEDED));
        }

        $link  = HTML_ROOT;
        $lang  = Flat::language();
        $link .= "/$lang/$pageName.php";
        $params = $this->getGetParams();

        if (!empty($controllerName)) {
            $params['controller'] = $controllerName;
        }

        if (!empty($params)) {
            $link .= '?';
            $parts = [];
            foreach (array_reverse($params) as $paramName => $paramValue) {
                $parts[] = "$paramName=$paramValue";
            }
            $link .= implode('&', $parts);
        }
        return $link;
    }

    /**
     * get an html link
     *
     * @param array $attributes
     * @return string
     * @throws base_ui_model_Exception
     */
    public function getHtmlTag($attributes = array())
    {
        $attributes['href'] = $this->getLinkString();
        return Html::url($this->getLinkString(), $this->getDisplayName(), $attributes);
    }


}