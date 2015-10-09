<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 17.08.2014
 * Time: 15:11
 */

require_once dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/php/test/TestCase.php';

class base_database_statement_test_ShowColTest extends base_test_TestCase
{

    /**
     * @test
     */
    public function toStringTest()
    {
        $showColumnsString = new base_database_statement_ShowCol();
        $showColumnsString->setTableName('test');
        $this->assertEquals('SHOW COLUMNS FROM test', $showColumnsString->toString());
    }
} 