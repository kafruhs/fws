<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.10.2014
 * Time: 12:37
 */

abstract class View
{
    /**
     * @var Controller
     */
    protected $controller;

    /**
     * instanciate and set controller
     *
     * @param Controller $controller
     */
    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    /**
     * display the content of this View
     *
     * @param OutputDevice $od
     */
    abstract public function display(OutputDevice $od);

    /**
     * get the title of the displayed page
     *
     * @return string
     */
    public function getPageTitle()
    {
        return TMS('base.page.defaultTitle');
    }

    /**
     * get the description of the displayed Page
     *
     * @return string
     */
    public function getPageDescription()
    {
        return TMS('base.page.defaultDescription');
    }


}