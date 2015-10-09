<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 22.10.2014
 * Time: 09:19
 */

interface Renderable
{
    /**
     * display the content of this View
     *
     * @param OutputDevice $od
     */
    public function display(OutputDevice $od);
} 