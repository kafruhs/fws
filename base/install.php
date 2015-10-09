<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.01.2015
 * Time: 09:27
 */
if (!file_exists('../../config.php')) {
    copy('root/config.php', dirname(dirname(__DIR__)) . '/config.php');
}

require_once ('../../config.php');
$od = new OutputDevice();

base_ui_Site::displayHead($od);
base_ui_Site::displayTop($od);
base_ui_Site::startMainContent($od);

$od->addContent(Html::startTag('h3'));
$od->addContent('Installation');
$od->addContent(Html::endTag('h3'));
print $od->toString();
$od->flush();

try {
    $setup = new base_install_Setup();
    $setup->execute($od);
} catch (Exception $e) {
    echo $e->getMessage();
}

base_ui_Site::endMainContent($od);
base_ui_Site::displayBottom($od);

print $od->toString();