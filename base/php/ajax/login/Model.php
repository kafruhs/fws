<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 21.01.2015
 * Time: 08:23
 */

class base_ajax_login_Model extends base_ajax_Model
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
        $this->setRedirectUrl($this->data['redirect']);
        $ret = User::login($this->data['userid'], $this->data['password']);
        if ($ret == User::LOGIN_SUCCESS) {
            $this->returnCode = self::PROCEED_TO_NEXT_PAGE;
            $this->msg = "Sie wurden erfolgreich eingeloggt.";
            return;
        }
        $this->returnCode = self::STAY_ON_ACTUAL_PAGE;
        if ($ret == User::LOGIN_USER_DISABLED) {
            $this->msg = "Dieser Benutzer ist gesperrt, bitte wenden Sie sich an einen Administrator";
            return;
        }
        $this->msg = "Sie konnten nicht eingeloggt werden. Bitte überprüfen Sie Kennung und Passwort.";
    }
}