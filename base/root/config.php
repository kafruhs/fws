<?php
/**
 * Created by PhpStorm.
 * User: Mediacenter
 * Date: 01.08.2014
 * Time: 08:12
 */

require_once('modules/base/defines/ErrorCodes.php');
require_once('modules/base/php/Autoloader.php');

define('ROOT', __DIR__);
define('HTML_ROOT', Configuration::get()->getEntry('projectUrl'));
session_start();

spl_autoload_register('__autoload');
set_exception_handler('exception_handler');

function exception_handler(Exception $exception) {
    $div = Html::startTag('div', array('id' => 'exceptionBox'));
    $div .= Html::startTag('p', array('class' => 'h3')) . TMS(BaseException::HEADLINE) . Html::endTag('p');
    $div .= Html::startTag('hr');
    $div .= $exception->getMessage();
    $div .= Html::endTag('div');
    print($div);
    if ($exception instanceof BaseException) {
        $exception->debugOut();
    }
}

function __autoload($className)
{
    $autoloader = Autoloader::singleton();
    $autoloader->loadClass($className);
}


function dump($input)
{
    if (is_array($input) || is_object($input)) {
        echo '<pre>', print_r($input), '</pre>';
    } else {
        echo $input . '<br />' . PHP_EOL;
    }
}

function TMS($name, $mappings = array())
{
    $tms = new TMS();
    $tms->setModule($name);
    $tms->load();
    return $tms->getValue($mappings);
}

