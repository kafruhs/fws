<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 05.08.2015
 * Time: 10:37
 */

class base_pages_input_controller_BaseObject extends Controller
{
    /**
     * @return View
     */
    public function getView()
    {
        return new base_pages_input_view_BaseObject($this);
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return new base_pages_input_model_BaseObject($this);
    }

    /**
     * @throws base_exception_Validation
     */
    public function validateParams()
    {
        parent::validateParams();
        if (is_null($this->requestHelper->getParam('class'))) {
            throw new base_exception_Site(TMS(base_exception_Site::MISSING_PARAM, ['name' => 'class']));
        }
    }


}