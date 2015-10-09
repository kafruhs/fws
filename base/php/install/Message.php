<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.01.2015
 * Time: 10:14
 */

class base_install_Message
{
    /**
     * print out a given message to inform the user during installation progress
     *
     * @param string        $message
     * @param OutputDevice  $od
     */
    public static function printOut($message, OutputDevice $od)
    {
        $od->addContent('[' . date('Y/m/d H:i:s') . '] ' . $message . "<br />");
    }
}