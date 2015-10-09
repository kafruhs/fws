<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 09.11.2014
 * Time: 19:34
 */

class base_login_controller_Extended extends Controller
{
    /**
     * @return View
     */
    public function getView()
    {
        return new base_login_view_Extended($this);
    }

}