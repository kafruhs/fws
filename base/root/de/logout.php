<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 16.12.2014
 * Time: 14:40
 */

require_once dirname(__DIR__) . '/config.php';

if (User::logout() == User::LOGOUT_SUCCESS) {
    header('location: ' . HTML_ROOT . '/index.php');
} else {
    $msg = (Html::startTag('p'));
    $msg .= ('Ausloggen war nicht möglich');
    $msg .= (Html::endTag('p'));
}

$od = new OutputDevice();

base_ui_Site::displayHead($od);
base_ui_Site::displayTop($od);
base_ui_Site::displayNavigation($od);
base_ui_Site::startMainContent($od);

$od->addContent(Html::startTag('h3'));
$od->addContent('Benutzer LogIn');
$od->addContent(Html::endTag('h3'));

print $od->toString();
$od->flush();

$od->addContent(Html::startTag('div', array('id' => 'ajaxMsg')) . Html::endTag('div'));
$od->addContent($msg);

base_ui_Site::endMainContent($od);
base_ui_Site::displayBottom($od);

print $od->toString();
