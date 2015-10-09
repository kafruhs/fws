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
$od->addContent('Artikelangebote');
$od->addContent(Html::endTag('h3'));

if (!User::isLoggedIn()) {
    $od->addContent('Sie sind nicht eingeloggt');
} else {
    /** @var MedOffer $obj */
    $obj = Factory::createObject('medOffer');
    $table = DB::table($obj->getTable());
    $where = DB::where($table->getColumn('offerAmount'), DB::intTerm(0), base_database_Where::GREATER);
    /** @var BaseObject[] $objs */
    $objs = Finder::create('medOffer')->setWhere($where)->find();
    if (empty($objs)) {
        $od->addContent('Keine Datensätze gefunden');
    } else {
        $table = new base_html_model_Table();
        $table->setCssClass('offerTable');

        $headRow = new base_html_model_table_Row();
        $headRow->setRowType(base_html_model_table_Row::ROWTAG_HEAD);
        /** @var Fieldinfo[] $fis */
        $fis = [];
        foreach ($obj->getFieldsForOfferPage() as $field) {
            $fi = $obj->getFieldinfo($field);
            $cell = new base_html_model_table_Cell();
            $cell->setCssId($fi->getFieldName());
            $cell->setContent($fi->getFieldLabel());
            $headRow->addCell($cell);
            $fis[] = $fi;
        }

        $cell = new base_html_model_table_Cell();
        $cell->setCssClass('orderAmount');
        $cell->setContent('Bestellmenge');
        $headRow->addCell($cell);
        $table->addHeadRow($headRow);

        foreach ($objs as $obj) {
            $obj['name'] .= ' ' . $obj->getField('amount') . ' ' . $obj->getField('unit') . ' ' . $obj->getField('dosage');
            $row = new base_html_model_table_Row();
            $row->setId($obj['LK']);
            foreach ($fis as $fi) {
                $formElement = base_form_element_Factory::createElement($fi);
                $formElement->setMultiline();
                $formElement->setName($fi->getFieldName());
                $formElement->setValue($obj->getField($fi->getFieldName()));
                $displayClassName = 'base_displayclass_' . ucfirst($fi->getDisplayClass());
                /** @var DisplayClass $dpC */
//                $dpC = new $displayClassName($obj);
//                $displayMode = $dpC->getDisplayMode(DisplayClass::VIEW);
                $formElement->setDisplayMode(DisplayClass::VIEW);
                $cell = new base_html_model_table_Cell();
                $cell->setCssID($fi->getFieldName());
                $cell->setCssClass($formElement->getClass());
                $cell->setContent($formElement->display());
                $row->addCell($cell);
            }
            $cell = new base_html_model_table_Cell();
            $cell->setCssClass('orderAmount');
            $medOrder = Factory::createObject('MedOrder');
            $fi = $medOrder->getFieldinfo('amount');
            $formElement = base_form_element_Factory::createElement($fi);
            $formElement->setClass($formElement->getClass() . ' orderAmount');
            $formElement->setMultiline();
            $formElement->setName('orderAmount');
            $formElement->setValue(0);
            $formElement->setDisplayMode(DisplayClass::EDIT);
            $content = $formElement->display();
            $formElement = new base_form_element_Hidden($obj->getFieldinfo('LK'));
            $formElement->setMultiline();
            $formElement->setName('LK');
            $value = $obj['LK'];
            $formElement->setValue($value);
            $content .= " " . $formElement->display();
            $cell->setContent($content);
            $row->addCell($cell);
            $table->addRow($row);
        }
        $od->addContent($table->toString());

        $table = new base_html_model_Table();
        $table->setId('orderTable');
        $row = new base_html_model_table_Row();
        $row->setRowType(base_html_model_table_Row::ROWTAG_HEAD);

        $titlesForOrderTable = array('Artikel', 'NettoPreis', 'Menge', 'Gesamt');
        foreach ($titlesForOrderTable as $title) {
            $cell = new base_html_model_table_Cell();
            $cell->setContent($title);
            $row->addCell($cell);
        }
        $table->addHeadRow($row);

        $orderBox = Html::startTag('div', array('id' => 'order'));
        $orderBox .= Html::startTag('p', array('id' => 'orderHeadline')) . 'Warenkorb' . Html::endTag('p');
        $orderBox .= Html::startTag('div', array('id' => 'orderNoContent'))
            . 'Es wurden noch keine Waren ausgewählt'
            . Html::endTag('div');
        $orderBox .= Html::startTag('div', array('id' => 'orderContent'));
        $form = new base_html_model_Form();
        $orderBox .= $form->start('ajax.php?controller=medexchange_ajax_save_medorder_Controller', 'post', array('class' => 'ajaxForm'));
        $orderBox .= $table->toString();
        $orderBox .= Html::startTag('div', array('id' => 'totalAmount'))
            . "Gesamt:\t" . Html::startTag('span') . Html::endTag('span') . " €"
            . Html::endTag('div') . "<br />";
        $formElement = new base_form_element_Submit(new Fieldinfo('MedOffer'));
        $formElement->setName('submit');
        $formElement->setValue('Absenden');
        $orderBox .= $formElement->display();
        $orderBox .= $form->end();
        $orderBox .= Html::endTag('div');
        $orderBox .= Html::endTag('div');
        $od->addContent(
            $orderBox);
    }
}

base_ui_Site::endMainContent($od);
base_ui_Site::displayBottom($od);

print $od->toString();