<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 27.07.2015
 * Time: 10:23
 */

class base_pages_acp_controller_Main extends Controller
{
    /**
     * @return base_pages_acp_view_Main
     */
    public function getView()
    {
        return new base_pages_acp_view_Main($this);
    }

    /**
     * @return base_pages_acp_model_Main
     */
    public function getModel()
    {
        return new base_pages_acp_model_Main($this);
    }

}