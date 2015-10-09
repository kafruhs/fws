<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 21.01.2015
 * Time: 08:21
 */

class medexchange_ajax_save_medorder_Controller extends base_ajax_Controller
{

    /**
     * get the model according to the controller
     *
     * @return base_ajax_Model
     */
    protected function getModel()
    {
        return new medexchange_ajax_save_medorder_Model($this);
    }
}