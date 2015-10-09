<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09.11.2014
 * Time: 13:09
 */

class base_ui_site_Header
{
    /**
     * css class for design of the headline
     *
     * @var string
     */
    protected $cssClass = 'header';

    /**
     * content of the headline
     *
     * @var string
     */
    protected $content;

    public function __construct()
    {
        $this->setInitialContent();
    }

    /**
     * @return string
     */
    public function getCssClass()
    {
        return $this->cssClass;
    }

    /**
     * @param string $cssClass
     */
    public function setCssClass($cssClass)
    {
        $this->cssClass = $cssClass;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function addContent($content)
    {
        $this->content .= $content;
    }

    /**
     * set initial content for the header section
     */
    public function setInitialContent()
    {
        $this->content = '';
    }

    /**
     * display the header div
     *
     * @param OutputDevice $od
     */
    public function display(OutputDevice $od)
    {
        $od->addContent(Html::startTag('body'));
        $od->addContent(Html::startTag('div', array('class' => 'pageStructure')) . "\n");
        $od->addContent(Html::startTag('div', array('class' => $this->getCssClass())) . "\n");
        $od->addContent($this->getContent());
        $od->addContent(Html::endTag('div'));
    }
}