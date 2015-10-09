<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.10.2014
 * Time: 12:43
 */

class base_setup_controller_Settings extends Controller
{
    /**
     */
    public function getView()
    {
        return new base_setup_view_Settings($this);
    }

    

}