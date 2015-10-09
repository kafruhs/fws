<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.01.2015
 * Time: 14:57
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

if (User::isLoggedIn()) {

    $gridScript = new base_js_JqGrid();
    $gridScript->setGetParams($requestHelper->getAllParams())->setRowNum(10);
    $gridScript->setGetParam('controller', 'base_ajax_search_Controller');
    $gridScript->setRowNum(25);

    $width = 0;
    foreach ($columnNames as $columnName) {
        $fi = $object->getFieldinfo($columnName);
        $width += $fi->getDisplayedLength();
        $dtObj = $fi->getDatatypeObject();
        $gridScript->setColModels($dtObj->getJSColModelElement());
        $colNames[] = $fi->getFieldLabel();
    }
    $gridScript->setColNames($colNames);
    $gridScript->setSortname('LK');
    $gridScript->setCaption($object->getDisplayName());

    $od->addContent($gridScript->toString());

    $table = new base_html_model_Table();
    $table->setId('searchTable');
    $od->addContent($table->toString());
    $od->addContent(Html::startTag('div', array('id' => 'navGrid')), Html::endTag('div'));

}

base_ui_Site::endMainContent($od);
base_ui_Site::displayBottom($od);

print $od->toString();