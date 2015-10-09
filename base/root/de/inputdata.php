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

$requestHelper = new RequestHelper();
$class = $requestHelper->getParam('class');
$viewMode = $requestHelper->getParam('mode');
if (is_null($class)) {
    throw new base_exception_Site(TMS(base_exception_Site::PARAM_MISSING, array('param' => 'class')));
}

if (!in_array($viewMode, array(DisplayClass::EDIT, DisplayClass::VIEW))) {
    $viewMode = DisplayClass::VIEW;
}

$obj = Factory::loadObject($class, $requestHelper->getParam('LK'));
if (is_null($obj)) {
    $obj = Factory::createObject($class);
}

$user = Flat::user();
$dataPermission = DataPermission::createObject($obj);
if (!User::isLoggedIn() || !$user->isEntitled($obj->getPermissionForViewMode($viewMode)) || !$dataPermission->isUserOccupant($user->getLogicalKey())) {
    $od->addContent('Sie verfügen nicht über die benötigten Rechte, um diese Datenkategorie zu bearbeiten. Bitte wenden Sie sich an den Support');
    $viewMode = DisplayClass::VIEW;
}

$od->addContent(Html::startTag('h3'));
$od->addContent('Datenerfassung: ' . $obj->getDisplayName());
$od->addContent(Html::endTag('h3'));

$formModel = new base_form_Model($obj, $viewMode);
$formModel->setAjaxForm('base_ajax_save_Controller');
$formModel->setMethod(base_form_Model::METHOD_POST);
$formModel->addAction("&class=$class");
$formModel->setId('inputData');
$formView = new base_form_View($formModel);
$od->addContent($formView->showStartTag());
$od->addContent($formView->showBody());
$od->addContent($formView->showSubmit());

base_ui_Site::endMainContent($od);
base_ui_Site::displayBottom($od);

print $od->toString();

//$fi = new Fieldinfo('user');
//$fi->load('PK');
//
//$test = base_form_element_Factory::createElement($fi->getDataType());

//$input = new base_form_element_Alphanumeric();
//$input->setMultiline();
//$input->setName('mist');
//$input->setMaxlength(10);
//$input->setSize(50);
//$input->setValue('Sack');
//$input->setDisplayMode(DisplayClass::HIDE);
//dump($input->display());


