<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 17.08.2014
 * Time: 16:18
 */
require_once dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/php/test/TestCase.php';

class base_database_term_IntTest extends base_test_TestCase
{
    public function toStringTestDataProvider()
    {
        return [
            [1, false],
            [1.1, true],
            ['test', true],
            [true, true]
        ];
    }

    /**
     * @param $value
     * @param $expectedException
     * @throws base_database_Exception
     *
     * @test
     * @dataProvider toStringTestDataProvider
     */
    public function toStringTest($value, $expectedException)
    {
        if ($expectedException === true) {
            $this->setExpectedException('base_database_Exception', TMS(base_database_Exception::NO_INT_VALUE, array('value' => $value)));
        }

        $term = new base_database_term_Int();
        $term->setValue($value);

        $this->assertEquals($value, $term->toString());
    }
} 