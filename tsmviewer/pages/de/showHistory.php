<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.02.2015
 * Time: 07:50
 */

require_once (dirname(__DIR__) . '/config.php');

$od = new OutputDevice();

base_ui_Site::displayHead($od);
base_ui_Site::displayTop($od);
base_ui_Site::displayNavigation($od);
base_ui_Site::startMainContent($od);

print $od->toString();
$od->flush();

$od->addContent(Html::startTag('h3'));
$od->addContent('Summary');
$od->addContent(Html::endTag('h3'));

$table = DB::table(Factory::createObject('TSMSummary')->getTable());
$dateTime = new base_date_model_DateTime(new DateTime('2015-01-01 00:00:00'));
$where = DB::where($table->getColumn('startTime'), DB::term($dateTime->toDB()), base_database_Where::GREATER);
$order = DB::order($table->getColumn('startTime'));
$finder = Finder::create('TSMSummary')->setWhere($where)->setOrder($order);
$objs = $finder->find();

$times = [];
$nodeNames = [];
$sortedObjects = [];
foreach ($objs as $obj) {
    /** @var base_date_model_DateTime $startTime */
    $startTime = $obj['startTime'];
    $nodeName = $obj['nodeName'];
    if (strpos($nodeName, 'FULLVM')) {
        $nodeName = $obj['subEntity'] . ' (FULLVM)';
    }
    if (!in_array($nodeName, $nodeNames)) {
        $nodeNames[] = $nodeName;

    }

    $startTimeString = $startTime->display('d.m.Y');
    if (!in_array($startTimeString, array_keys($times))) {
        $times[$startTimeString] = $startTime;
    }

    $sortedObjects[$startTimeString][$nodeName] = $obj;

}

$table = new base_html_model_Table();
$headRow = new base_html_model_table_Row();
$cell = new base_html_model_table_Cell();
$cell->setContent('Node');
$headRow->addCell($cell);
foreach (array_values($times) as $time) {
    $cell = new base_html_model_table_Cell();
    $cell->setContent($time->display('d'));
    $headRow->addCell($cell);
}
$table->addHeadRow($headRow);
foreach ($nodeNames as $nodeName) {
    $row = new base_html_model_table_Row();
    $cell = new base_html_model_table_Cell();
    $cell->setContent($nodeName);
    $row->addCell($cell);
    foreach ($times as $time => $timeObj) {
        if (!isset($sortedObjects[$time][$nodeName])) {
            $cell = new base_html_model_table_Cell();
            $cell->setContent(' ');
            $cell->setCssClass('noData');
            $row->addCell($cell);
            continue;
        }
        $obj = $sortedObjects[$time][$nodeName];
        $cell = new base_html_model_table_Cell();
        $cell->setContent(' ');
        switch ($obj['successful']) {
            case 0:
                $cell->setCssClass('success');
                break;
            case 1:
                $cell->setCssClass('missedFiles');
                break;
            case 3:
                $cell->setCssClass('missed');
                break;
            default:
                $cell->setCssClass('failed');
                break;
        }
        $row->addCell($cell);
    }
    $table->addRow($row);

}
$od->addContent($table->toString());

base_ui_Site::endMainContent($od);
base_ui_Site::displayBottom($od);

print $od->toString();