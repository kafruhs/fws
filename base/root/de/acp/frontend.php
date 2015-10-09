<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.01.2015
 * Time: 11:54
 */

require_once (dirname(dirname(__DIR__)) . '/config.php');

$od = new OutputDevice();

if (!Flat::user()->isEntitled('Administrator')) {
    base_ui_Site::displayHead($od);
    base_ui_Site::displayTop($od);
    base_ui_Site::displayNavigation($od);
    base_ui_Site::startMainContent($od);
    $od->addContent('Sie sind nicht berechtigt diesen Bereich zu benutzen.');
    base_ui_Site::endMainContent($od);
    base_ui_Site::displayBottom($od);

} else {
    base_ui_ACP::displayHead($od);
    base_ui_ACP::displayTop($od);
    base_ui_ACP::displayNavigation($od);
    base_ui_ACP::startMainContent($od);

    $rh = new RequestHelper();
    $controllerClass = $rh->getParam('controller');

    /** @var Controller $controller */
    $controller = new $controllerClass(Controller::CALLER_SECTION_ACP);
    $controller->validateParams();
    $od->addContent(Html::startTag('h3'));
    $od->addContent($controller->getPageTitle());
    $od->addContent(Html::endTag('h3'));

    $controller->display($od);

    base_ui_ACP::endMainContent($od);
    base_ui_ACP::displayBottom($od);
}

print $od->toString();
