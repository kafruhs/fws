<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 08.04.2015
 * Time: 08:32
 */

class MedOrder extends BaseObject
{
    protected $table = 'medOrder';

    protected $fieldsForPDF = array(
        'name',
        'pzn',
        'sellerId',
        'price',
        'amount',
    );

    protected $stdSearchColumns = [
        'sellerId',
        'firstEditor',
        'pzn',
        'name',
        'price',
        'amount'
    ];
}