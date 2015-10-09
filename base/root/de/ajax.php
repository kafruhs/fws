<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * date: 11.04.2014
 * Time: 08:49
 */

require_once dirname(__DIR__) . '/config.php';

ob_start();
$requestHelper = new RequestHelper();

$controllerClass = $requestHelper->getParam('controller');

if (class_exists($controllerClass) === false) {
    response(base_ajax_Model::STAY_ON_ACTUAL_PAGE, base_ajax_Controller::ERROR_CONTROLLER_NOT_FOUND);
    exit();
}

/** @var base_ajax_Controller $controller */
$controller = new $controllerClass($requestHelper);
$controller->setCallerSection($requestHelper->getParam('caller'));
$controller->executeRequest();

/** @todo callerSection durchreichen */

exit();