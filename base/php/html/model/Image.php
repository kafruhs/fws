<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09.11.2014
 * Time: 15:02
 */

class base_html_model_Image
{
    /**
     * @var string
     */
    protected $src;

    /**
     * @var string
     */
    protected $cssClass = 'images';

    /**
     * @var string
     */
    protected $altName = '';

    /**
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @param string $src
     */
    public function setSrc($src)
    {
        $this->src = $src;
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
    public function getAltName()
    {
        return $this->altName;
    }

    /**
     * @param string $altName
     */
    public function setAltName($altName)
    {
        $this->altName = $altName;
    }

    /**
     * get an images string
     *
     * @return string
     */
    public function toString()
    {
        return "<img src='" . HTML_ROOT . "/images/{$this->getSrc()}' alt={$this->getAltName()} class={$this->getCssClass()} />";
    }
}