<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 21.01.2015
 * Time: 08:23
 */

class base_ajax_delete_Model extends base_ajax_Model
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
        $error = null;
        $requestHelper = $this->controller->getRequestHelper();
        $ret = BaseObject::SAVE_FAILURE;
        try {
            $class = $requestHelper->getParam('class');
            $lk = (int) $requestHelper->getParam('LK');
            $obj = Factory::loadObject($class, $lk);
            if (empty($obj)) {
                $this->msg = "Es wurde kein LK zum Löschen ausgewählt";
                return;
            } else {

            }
            $dbObj = base_database_connection_Mysql::get();
            $dbObj->beginTransaction();
            $ret = $obj->delete();
            $dbObj->endTransaction();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        if (!is_null($error)) {
            $this->msg = $error;
            return;
        }
        $this->returnCode = self::PROCEED_TO_NEXT_PAGE;
        $this->redirectUrl = $_SERVER['HTTP_REFERER'];
        if ($ret == BaseObject::DELETE_SUCCESS) {
            $this->msg = "Der Datensatz '$lk' wurde erfolgreich gelöscht.";
            return;
        }
        $this->msg = "Der Datensatz '$lk' konnte nicht gelöscht werden";
    }
}