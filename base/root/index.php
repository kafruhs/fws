<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.01.2015
 * Time: 14:57
 */

require_once 'config.php';

$od = new OutputDevice();

base_ui_Site::displayHead($od);
base_ui_Site::displayTop($od);
base_ui_Site::displayNavigation($od);
base_ui_Site::startMainContent($od);

print $od->toString();
$od->flush();

$od->addContent(Html::startTag('h3'));
$od->addContent('Startseite');
$od->addContent(Html::endTag('h3'));

base_ui_Site::endMainContent($od);
base_ui_Site::displayBottom($od);

print $od->toString();
