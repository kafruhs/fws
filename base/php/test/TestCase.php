<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 17.08.2014
 * Time: 15:12
 */

require_once 'PHPUnit/Autoload.php';

class base_test_TestCase extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
        require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/config.php';
    }
}

