<?php
/**
 * Created by PhpStorm.
 * User: Mediacenter
 * Date: 01.08.2014
 * Time: 08:40
 */

class Logger
{
    public static function output($fileName, $msg)
    {
        $fileName = ROOT . "/logs/$fileName";
        $fd = @fopen($fileName, 'a+');
        $str = "[" . date("d/m/Y h:i:s", time()) . "]" . $msg;
        fwrite($fd, $str . PHP_EOL);
        fclose($fd);
        chmod($fileName, 0644);
    }
} 