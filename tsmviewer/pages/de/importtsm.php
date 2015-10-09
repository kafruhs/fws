<?php
/**
 * Created by PhpStorm.
 * User: Mediacenter
 * Date: 01.08.2014
 * Time: 07:24
 */
require_once(dirname(__DIR__) . "/config.php");

$od = new OutputDevice();

base_ui_Site::displayHead($od);
base_ui_Site::displayTop($od);
base_ui_Site::displayNavigation($od);
base_ui_Site::startMainContent($od);

$od->addContent(Html::startTag('h3'));
$od->addContent('Import der TSMServer Klassen');
$od->addContent(Html::endTag('h3'));

$importer = new base_importer_csv_BaseObject('tsmserver', ROOT . "/modules/tsmviewer/init/tsmserver_data.csv");
$importer->import();

$result = Finder::create('TSMServer')->find();

$od->addContent(Html::startTag('ul'));

foreach ($result as $obj) {
    TSMServerManager::get()->setActualTsmServerLK((int) $obj['LK']);
    $od->addContent(Html::startTag('li', array('class' => 'serverList')));
    $od->addContent("Import der Daten zu TSM Server '{$obj['name']}'");
    $od->addContent(Html::startTag('ul'));

    $importer = new tsmviewer_importer_csv_TSMObject('tsmdomain', ROOT . "/modules/tsmviewer/init/tsmdomain_{$obj['LK']}_data.csv", ',', false);
    $ret = $importer->import();

    if ($ret == tsmviewer_importer_csv_TSMObject::SUCCESS) {
        $od->addContent(Html::startTag('li'));
        $od->addContent("Die Domains wurden erfolgreich importiert");
        $od->addContent(Html::endTag('li'));
    }

    $importer = new tsmviewer_importer_csv_TSMObject('tsmcollocgroup', ROOT . "/modules/tsmviewer/init/tsmcollocgroup_{$obj['LK']}_data.csv", ',', false);
    $ret = $importer->import();

    if ($ret == tsmviewer_importer_csv_TSMObject::SUCCESS) {
        $od->addContent(Html::startTag('li'));
        $od->addContent("Die Collocation Groups wurden erfolgreich importiert");
        $od->addContent(Html::endTag('li'));
    }

    $importer = new tsmviewer_importer_csv_TSMObject('tsmnode', ROOT . "/modules/tsmviewer/init/tsmnode_{$obj['LK']}_data.csv", ',', false);
    $ret = $importer->import();

    if ($ret == tsmviewer_importer_csv_TSMObject::SUCCESS) {
        $od->addContent(Html::startTag('li'));
        $od->addContent("Die Nodes wurden erfolgreich importiert");
        $od->addContent(Html::endTag('li'));
    }

    $importer = new tsmviewer_importer_csv_TSMObject('tsmsummary', ROOT . "/modules/tsmviewer/init/tsmsummary_{$obj['LK']}_data.csv", ',', false);
    $ret = $importer->import();

    if ($ret == tsmviewer_importer_csv_TSMObject::SUCCESS) {
        $od->addContent(Html::startTag('li'));
        $od->addContent("Das TSMSummary wurde erfolgreich importiert");
        $od->addContent(Html::endTag('li'));
    }

    $od->addContent(Html::endTag('ul'));
    $od->addContent(Html::endTag('li'));
    $od->addContent(Html::singleTag('br'));
}

base_ui_Site::endMainContent($od);
base_ui_Site::displayBottom($od);

print $od->toString();