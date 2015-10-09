<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.09.2014
 * Time: 14:20
 */

class OutputDevice
{
    /**
     * @var string
     */
    protected $content;


    /**
     * and some content to the OutputDevice
     *
     * @param string $content
     */
    public function addContent($content)
    {
        $this->content .= $content;
    }

    /**
     * return the content
     *
     * @return string
     */
    public function toString()
    {
        return $this->content;
    }

    /**
     *  set content empty
     */
    public function flush()
    {
        $this->content = '';
    }
} 