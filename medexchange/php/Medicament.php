<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02.03.2015
 * Time: 07:57
 */

class Medicament extends BaseObject
{
    protected $table = 'medicament';

    protected $stdSearchColumns = array('name', 'FK_vendor', 'pzn', 'price', 'mwst', 'amount', 'unit', 'dosage', 'type');
}