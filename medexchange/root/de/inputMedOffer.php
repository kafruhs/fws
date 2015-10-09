<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23.03.2015
 * Time: 17:22
 */

require_once ('../config.php');
$od = new OutputDevice();

base_ui_Site::displayHead($od);
base_ui_Site::displayTop($od);
base_ui_Site::displayNavigation($od);
base_ui_Site::startMainContent($od);

$od->addContent(Html::startTag('h3'));
$od->addContent('Eingabe eines Biete-Artikels');
$od->addContent(Html::endTag('h3'));

if (!User::isLoggedIn()) {
    $od->addContent('Sie sind nicht eingeloggt');
} else {


    $requestHelper = new RequestHelper();
    $lk = $requestHelper->getParam('lk');
    $medOffer = null;
    if (!is_null($lk)) {
        $medOffer = Factory::loadObject('medOffer', (int) $lk);
    }
    if (!$medOffer instanceof MedOffer) {
        $medOffer = Factory::createObject('medOffer');
    }
    $form = new base_form_Model($medOffer, DisplayClass::EDIT);
    $form->setAjaxForm('base_ajax_save_Controller');
    $form->addAction('&class=MedOffer');
    $form->setId('inputData');
    $formView = new base_form_View($form);
    $od->addContent($formView->showStartTag());
    $od->addContent($formView->showBody());
    $od->addContent($formView->showSubmit());
}

base_ui_Site::endMainContent($od);
base_ui_Site::displayBottom($od);

print $od->toString();