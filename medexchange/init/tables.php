<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.01.2015
 * Time: 10:26
 */

$manager = base_install_Manager::get();

/** --------------- table medicament ---------------*/
$table = new base_install_table_BaseObject('medicament');

$col = new base_install_Column('name');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('FK_vendor');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$col = new base_install_Column('pzn');
$col->setType(base_install_Column::INT)->setLength(5);
$table->addColumn($col);

$col = new base_install_Column('price');
$col->setType(base_install_Column::FLOAT)->setLength(10)->setDefault('0.00');
$table->addColumn($col);

$col = new base_install_Column('amount');
$col->setType(base_install_Column::INT)->setDefault(0);
$table->addColumn($col);

$col = new base_install_Column('unit');
$col->setType(base_install_Column::VARCHAR)->setLength(10)->setNull();
$table->addColumn($col);

$col = new base_install_Column('mwst');
$col->setType(base_install_Column::INT)->setLength(10)->setDefault(19);
$table->addColumn($col);

$col = new base_install_Column('dosage');
$col->setType(base_install_Column::VARCHAR)->setLength(10)->setNull();
$table->addColumn($col);

$col = new base_install_Column('type');
$col->setType(base_install_Column::VARCHAR)->setLength(10)->setNull();
$table->addColumn($col);

$manager->addTable($table);

/** --------------- table vendor ---------------*/
$table = new base_install_table_BaseObject('vendor');

$col = new base_install_Column('name');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('number');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$manager->addTable($table);

/** --------------- table medOffer ---------------*/
$table = new base_install_table_BaseObject('medOffer');

$col = new base_install_Column('rabatt');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$col = new base_install_Column('offerAmount');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$col = new base_install_Column('name');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('FK_vendor');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$col = new base_install_Column('pzn');
$col->setType(base_install_Column::INT)->setLength(7);
$table->addColumn($col);

$col = new base_install_Column('price');
$col->setType(base_install_Column::FLOAT)->setLength(10)->setDefault('0.00');
$table->addColumn($col);

$col = new base_install_Column('amount');
$col->setType(base_install_Column::INT)->setDefault(0);
$table->addColumn($col);

$col = new base_install_Column('unit');
$col->setType(base_install_Column::VARCHAR)->setLength(10)->setNull();
$table->addColumn($col);

$col = new base_install_Column('mwst');
$col->setType(base_install_Column::INT)->setLength(10)->setDefault(19);
$table->addColumn($col);

$col = new base_install_Column('dosage');
$col->setType(base_install_Column::VARCHAR)->setLength(10)->setNull();
$table->addColumn($col);

$col = new base_install_Column('type');
$col->setType(base_install_Column::VARCHAR)->setLength(10)->setNull();
$table->addColumn($col);

$manager->addTable($table);

/** --------------- table medOrder ---------------*/
$table = new base_install_table_BaseObject('medOrder');

$col = new base_install_Column('amount');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$col = new base_install_Column('FK_medoffer');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$col = new base_install_Column('sellerId');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$col = new base_install_Column('price');
$col->setType(base_install_Column::FLOAT)->setLength(10)->setDefault('0.00');
$table->addColumn($col);

$col = new base_install_Column('pzn');
$col->setType(base_install_Column::INT)->setLength(7);
$table->addColumn($col);

$col = new base_install_Column('name');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$manager->addTable($table);
