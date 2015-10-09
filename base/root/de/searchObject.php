<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 10.06.2015
 * Time: 07:46
 */

require_once dirname(__DIR__) . '/config.php';

$od = new OutputDevice();

base_ui_Site::displayHead($od);
base_ui_Site::displayTop($od);
base_ui_Site::displayNavigation($od);
base_ui_Site::startMainContent($od);

print $od->toString();
$od->flush();

$requestHelper = new RequestHelper();

$class = $requestHelper->getParam('class');

if (is_null($class)) {
    throw new base_exception_Site(TMS(base_exception_Site::PARAM_MISSING, array('param' => 'class')));
}

$object = Factory::createObject($class);

$user = Flat::user();

if (!User::isLoggedIn() || !$user->isEntitled($object->getPermissionForViewMode(DisplayClass::VIEW))) {
    $od->addContent('Sie verfügen nicht über die benötigten Rechte, um diese Datenkategorie zu betrachten. Bitte wenden Sie sich an den Support');
    base_ui_Site::endMainContent($od);
    base_ui_Site::displayBottom($od);

    print $od->toString();
    exit();
}

$urlColumns = $requestHelper->getParam('cols');
if (!is_null($urlColumns)) {
    if ($urlColumns == 'all') {
        $fi = new Fieldinfo($class);
        $columnNames = $fi->getAllFieldNames();
    } else {
        $columnNames = explode(',', $urlColumns);
    }
} else {
    $columnNames = $object->getStdSearchColumns();
}

$od->addContent(Html::startTag('h3'));
$od->addContent('Suchergebnisliste: ' . $object->getDisplayName());
$od->addContent(Html::endTag('h3'));
