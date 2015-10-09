<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 05.08.2015
 * Time: 10:38
 */

class base_pages_input_model_BaseObject extends Model
{
    /**
     * @var BaseObject
     */
    protected $obj;

    /**
     * set data
     */
    public function setData()
    {
        $requestHelper = $this->controller->getRequestHelper();
        $class = $requestHelper->getParam('class');
        $viewMode = $requestHelper->getParam('mode');

        if (!in_array($viewMode, array(DisplayClass::EDIT, DisplayClass::VIEW))) {
            $viewMode = DisplayClass::VIEW;
        }

        $obj = Factory::loadObject($class, $requestHelper->getParam('LK'));
        if (is_null($obj)) {
            $obj = Factory::createObject($class);
        }
        $this->obj = $obj;

        $user = Flat::user();
        $dataPermission = DataPermission::createObject($obj);
        if (!User::isLoggedIn() || !$user->isEntitled($obj->getPermissionForViewMode($viewMode)) || !$dataPermission->isUserOccupant($user->getLogicalKey())) {
            $viewMode = DisplayClass::VIEW;
        }

        $formModel = new base_form_Model($obj, $viewMode);
        $formModel->setAjaxForm('base_ajax_save_Controller');
        $formModel->setMethod(base_form_Model::METHOD_POST);
        $formModel->addAction("&class=$class");
        $formModel->addAction("&caller=" . $this->controller->getCallerSection());
        $formModel->setId('inputData');
        $this->data = new base_form_View($formModel);
    }

    /**
     * @return BaseObject
     */
    public function getObject()
    {
        return $this->obj;
    }

}