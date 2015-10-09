<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02.03.2015
 * Time: 17:46
 */

require_once ROOT . '/modules/base/extlib/phpmailer/PHPMailerAutoload.php';

class Mailer extends PHPMailer
{
    public function __construct()
    {
        parent::__construct();
        $config = Configuration::get();
        $this->isSMTP();
        $this->Host = $config->getEntry('smtpHost');
        $this->Username = $config->getEntry('smtpUserMail');
        $this->Password = $config->getEntry('smtpPassword');
        $this->Port = $config->getEntry('smtpPort');
        $this->SMTPSecure = 'ssl';
        $this->SMTPAuth = true;
        $this->From = $config->getEntry('smtpUserMail');
        $this->FromName = $config->getEntry('smtpUserName');
        $this->CharSet = 'utf8';
        $this->addReplyTo($config->getEntry('smtpUserMail'));
        $this->addBCC('bestellung@faercher-it.de');
    }

    public function postSend()
    {
        parent::postSend();
        $info = "Gesendet an: " . implode(', ', array_keys($this->all_recipients)) . " von " . $this->From;
        Logger::output('mail.log', $info);
    }
}