<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.01.2015
 * Time: 11:54
 */

require_once (dirname(__DIR__) . '/config.php');

$od = new OutputDevice();

base_ui_Site::displayHead($od);
base_ui_Site::displayTop($od);
base_ui_Site::displayNavigation($od);
base_ui_Site::startMainContent($od);

$rh = new RequestHelper();
$controllerClass = $rh->getParam('controller');

/** @var Controller $controller */
$controller = new $controllerClass();

$od->addContent(Html::startTag('h3'));
$od->addContent($controller->getPageTitle());
$od->addContent(Html::endTag('h3'));

$controller->display($od);

base_ui_Site::endMainContent($od);
base_ui_Site::displayBottom($od);

print $od->toString();
