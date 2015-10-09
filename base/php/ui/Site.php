<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 01.09.2014
 * Time: 19:38
 */

class base_ui_Site
{
    /**
     * set the <head> section of the page
     *
     * @param OutputDevice $od
     */
    public static function displayHead(OutputDevice $od)
    {
        $head = new base_ui_site_HeadSection();
        $head->display($od);
    }

    /**
     * display the main page structure as well as the header with the banner, title and thing like that
     *
     * @param OutputDevice $od
     */
    public static function displayTop(OutputDevice $od)
    {
        $header = new base_ui_site_Header();
        $header->display($od);
    }

    /**
     * display the navigation part of the page
     *
     * @param OutputDevice $od
     */
    public static function displayNavigation(OutputDevice $od)
    {
        $navi = new base_ui_site_Navigation();
        $navi->display($od);
    }

    /**
     * display the footer section of the page an shut down the main page structure
     *
     * @param OutputDevice $od
     */
    public static function displayBottom(OutputDevice $od)
    {
        $footer = new base_ui_site_Footer();
        $footer->display($od);
    }

    /**
     * starts the main content section of the page
     *
     * @param OutputDevice $od
     */
    public static function startMainContent(OutputDevice $od)
    {
        $od->addContent(Html::startTag('div', array('class' => 'mainContent', 'id' => 'mainContent')));
        $requestHelper = new RequestHelper();
        $ajaxMsg = $requestHelper->getParam('ajaxMsg');
        $od->addContent(Html::ajaxMsgDiv($ajaxMsg));
        $od->addContent(Html::loaderDiv());
    }

    /**
     * ends the main content section of the page
     *
     * @param OutputDevice $od
     */
    public static function endMainContent(OutputDevice $od)
    {
        $od->addContent(Html::endTag('div'));
    }
} 