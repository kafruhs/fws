<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.01.2015
 * Time: 10:26
 */

$manager = base_install_Manager::get();

/** --------------- table navigationCategory ---------------*/
$table = new base_install_table_BaseObject('employee');

$col = new base_install_Column('firstName');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('lastName');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('graduation');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('position');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('email');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('picture');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('description');
$col->setType(base_install_Column::TEXT);
$table->addColumn($col);

$manager->addTable($table);