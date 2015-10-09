<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 21.01.2015
 * Time: 08:21
 */

class base_ajax_save_Controller extends base_ajax_Controller
{

    /**
     * get the model according to the controller
     *
     * @return base_ajax_Model
     */
    protected function getModel()
    {
        return new base_ajax_save_Model($this);
    }
}