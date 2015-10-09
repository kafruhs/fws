<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.01.2015
 * Time: 14:57
 */

require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/config.php';

$od = new OutputDevice();

base_ui_Site::displayHead($od);
base_ui_Site::displayTop($od);
base_ui_Site::displayNavigation($od);
base_ui_Site::startMainContent($od);

$od->addContent(Html::startTag('h3'));
$od->addContent('Leeren des Caches');
$od->addContent(Html::endTag('h3'));

$rmdir = base_infrastructure_Folder::rmdirRecursive(ROOT . '/files/cache');
$mkdir = mkdir(ROOT . '/files/cache');
if ($rmdir == base_infrastructure_Folder::DELETE_FOLDER_SUCCESS && $mkdir) {
    $od->addContent('Der Cache wurde erfolgreich gelöscht');
} else {
    $od->addContent('Beim Cache leeren sind Probleme aufgetreten. Bitte wenden Sie sich an den Administrator');
}


base_ui_Site::endMainContent($od);
base_ui_Site::displayBottom($od);

print $od->toString();
