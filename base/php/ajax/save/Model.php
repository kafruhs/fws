<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 21.01.2015
 * Time: 08:23
 */

class base_ajax_save_Model extends base_ajax_Model
{
    /**
     * @return bool
     */
    protected function isExecuteable()
    {
        return true;
    }

    /**
     * execute the actual ajax request
     */
    protected function executeRequest()
    {
        $error = '';
        $requestHelper = $this->controller->getRequestHelper();
        try {
            $class = $requestHelper->getParam('class');
            $lk = (int) $requestHelper->getParam('LK');
            if (!empty($lk)) {
                $obj = Factory::loadObject($class, $lk);
            } else {
                $obj = Factory::createObject($class);
            }

            foreach ($requestHelper->getAllParams() as $fieldName => $value) {

                try {
                    $fi = $obj->getFieldinfo($fieldName);
                    if ($fi->isMandatory() && empty($value) && $fieldName != 'LK') {
                        $error .= TMS(base_exception_Fieldinfo::FIELD_IS_MANDATORY, array('field' => $fi->getFieldLabel())) . "<br />";
                    }
                    $obj[$fieldName] = $value;
                } catch (Exception $e) {

                }
            }
            if (empty($error)) {
                $dbObj = base_database_connection_Mysql::get();
                $dbObj->beginTransaction();
                $ret = $obj->save();
                $dbObj->endTransaction();
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        if (!empty($error)) {
            $this->msg = $error;
            return;
        }

        if ($this->controller->getCallerSection() == base_ajax_Controller::CALLER_SECTION_ACP) {
            $url = 'de/acp';
        } else {
            $url = 'de/';
        }
        switch ($requestHelper->getParam('referer')) {
            case base_form_View::SAVE_AND_EDIT:
                $this->returnCode = self::STAY_ON_ACTUAL_PAGE;
                break;
            case base_form_View::SAVE_AND_NEW:
                $this->returnCode = self::PROCEED_TO_NEXT_PAGE;
                $this->setRedirectUrl($url . '/frontend.php?controller=base_pages_input_controller_BaseObject&class=' . $class . '&mode=edit');
                break;
            case base_form_View::SAVE_AND_SEARCH:
                $this->returnCode = self::PROCEED_TO_NEXT_PAGE;
                $this->setRedirectUrl($url . '/frontend.php?controller=base_pages_search_controller_TableList&class=' . $class . '&mode=edit');
                break;
        }

        if ($ret == BaseObject::SAVE_SUCCESS) {
            $this->msg = "Der Datensatz wurde erfolgreich gespeichert.";
            return;
        }
        $this->returnCode = self::STAY_ON_ACTUAL_PAGE;
        if ($ret == BaseObject::SAVE_FAILURE) {
            $this->msg = "Der Datensatz konnte nicht gespeichert werden";
            return;
        }
        $this->msg = "Es wurden keine Veränderungen am Datensatz vorgenommen";
    }
}