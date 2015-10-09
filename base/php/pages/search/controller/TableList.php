<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 15.06.2015
 * Time: 07:15
 */

class base_pages_search_controller_TableList extends Controller
{
    /**
     * @var base_pages_search_Model
     */
    protected $model;

    /**
     * @return View
     */
    public function getView()
    {
        return new base_pages_search_view_TableList($this);
    }

    /**
     * @return base_pages_search_Model
     */
    public function getModel()
    {
        return new base_pages_search_Model($this);
    }

    /**
     * @return array
     */
    public function getColLabelNamesConnection()
    {
        return $this->model->getColLabelNamesConnection();
    }

    public function getPageTitle()
    {
        $obj = Factory::createObject($this->getClass());
        return 'Suchergebnis: ' . $obj->getDisplayName();
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->model->getClass();
    }

    public function getFilterParam($name)
    {
        $params = $this->model->getParams();
        return $params[$name];
    }

    public function countData()
    {
        return $this->model->countData();
    }


}