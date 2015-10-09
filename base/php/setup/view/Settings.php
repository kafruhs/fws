<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.10.2014
 * Time: 12:46
 */

class base_setup_view_Settings extends View
{
    /**
     */
    public function getPageTitle()
    {
        return TMS('base.setup.startPageTitle');
    }

    /**
     */
    public function getPageDescription()
    {
        return TMS('base.setup.startPageDescription');
    }


    /**
     * manages all page subelements and is defined in the different views
     *
     * @param OutputDevice $od
     */
    protected function _display(OutputDevice $od)
    {
        // TODO: Implement _display() method.
    }

    /**
     * implements the content of the viewed page
     *
     * @param OutputDevice $od
     */
    protected function addPageContent(OutputDevice $od)
    {
        // TODO: Implement addPageContent() method.
    }
}