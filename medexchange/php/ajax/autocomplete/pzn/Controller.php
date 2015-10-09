<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 24.03.2015
 * Time: 09:23
 */

class medexchange_ajax_autocomplete_pzn_Controller extends base_ajax_Controller
{

    /**
     * get the model according to the controller
     *
     * @return base_ajax_Model
     */
    protected function getModel()
    {
        return new medexchange_ajax_autocomplete_pzn_Model($this);
    }
}