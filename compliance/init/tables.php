<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.01.2015
 * Time: 10:26
 */

$manager = base_install_Manager::get();

/** --------------- table incident ---------------*/
$table = new base_install_table_BaseObject('incident');

$col = new base_install_Column('title');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('description');
$col->setType(base_install_Column::TEXT);
$table->addColumn($col);

$col = new base_install_Column('priority');
$col->setType(base_install_Column::INT)->setLength(2);
$table->addColumn($col);

$manager->addTable($table);
