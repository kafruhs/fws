<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 16.12.2014
 * Time: 14:40
 */

require_once dirname(__DIR__) . '/config.php';

$od = new OutputDevice();

base_ui_Site::displayHead($od);
base_ui_Site::displayTop($od);
base_ui_Site::displayNavigation($od);
base_ui_Site::startMainContent($od);

$od->addContent(Html::startTag('h3'));
$od->addContent('Benutzer LogIn');
$od->addContent(Html::endTag('h3'));

print $od->toString();
$od->flush();


if (User::isLoggedIn()) {
    $od->addContent('Zum Ausloggen bitte ' . Html::url(HTML_ROOT . '/' . Flat::language() . '/logout.php', 'hier') . "klicken\n");
} else {
    $od->addContent("<form method='post' action='ajax.php?controller=base_ajax_login_Controller&redirect=index.php' class='ajaxForm' >\n");
    $table = new base_html_model_Table();
    
    $labelCell = new base_html_model_table_Cell();
    $labelCell->setContent('Benutzername');
    $valueCell = new base_html_model_table_Cell();
    $obj = Factory::createObject('user');
    $inputUserName = base_form_element_Factory::createElement($obj->getFieldinfo('userid'));
    $inputUserName->setName('userid');
    $inputUserName->setDisplayMode(DisplayClass::EDIT);
    $valueCell->setContent($inputUserName->display());
    $rowUserId = new base_html_model_table_Row();
    $rowUserId->addCell($labelCell);
    $rowUserId->addCell($valueCell);
    $table->addRow($rowUserId);

    $labelCell = new base_html_model_table_Cell();
    $labelCell->setContent('Passwort');
    $valueCell = new base_html_model_table_Cell();
    $inputPassword = base_form_element_Factory::createElement($obj->getFieldinfo('password'));
    $inputPassword->setName('password');
    $inputPassword->setDisplayMode(DisplayClass::EDIT);
    $valueCell->setContent($inputPassword->display());
    $rowPassword = new base_html_model_table_Row();
    $rowPassword->addCell($labelCell);
    $rowPassword->addCell($valueCell);
    $table->addRow($rowPassword);
    
    $od->addContent( $table->toString());


    $submit = new base_form_element_Submit(new Fieldinfo('BaseObject'));
    $submit->setName('submit');
    $submit->setValue('Einloggen');
    
    $od->addContent($submit->display());
    $od->addContent("</form>\n");
}

base_ui_Site::endMainContent($od);
base_ui_Site::displayBottom($od);

print $od->toString();
