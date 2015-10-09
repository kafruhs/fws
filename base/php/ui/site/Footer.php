<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09.11.2014
 * Time: 13:39
 */

class base_ui_site_Footer
{
    /**
     * @var string
     */
    protected $cssClass = 'footer';

    /**
     * @var string
     */
    protected $content = '';

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
     * display the footer section of the page
     *
     * @param OutputDevice $od
     */
    public function display(OutputDevice $od)
    {
        $od->addContent(Html::startTag('div', ['style' => 'clear:both']) . Html::endTag('div'));
        $od->addContent(Html::startTag('div', array('class' => $this->getCssClass())));
        $od->addContent($this->getContent());
        $od->addContent(Html::endTag('div'));
        $od->addContent(Html::endTag('div'));
        $od->addContent(Html::endTag('body'));
    }

}