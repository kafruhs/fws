<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 16.07.2015
 * Time: 15:31
 */

class base_pages_news_controller_MainPage extends Controller
{
    /**
     * @return View
     */
    public function getView()
    {
        return new base_pages_news_view_MainPage($this);
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return new base_pages_news_Model($this);
    }

}