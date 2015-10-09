<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.01.2015
 * Time: 10:26
 */

$manager = base_install_Manager::get();

/** --------------- table tsmserver ---------------*/
$table = new base_install_table_BaseObject('tsmserver');

$col = new base_install_Column('name');
$col->setType(base_install_Column::VARCHAR)->setLength(200);
$table->addColumn($col);

$col = new base_install_Column('dns');
$col->setType(base_install_Column::VARCHAR)->setLength(200);
$table->addColumn($col);

$col = new base_install_Column('port');
$col->setType(base_install_Column::INT)->setLength(4);
$table->addColumn($col);

$manager->addTable($table);

/** --------------- table tsmnode ---------------*/
$table = new base_install_table_BaseObject('tsmnode');

$col = new base_install_Column('name');
$col->setType(base_install_Column::VARCHAR)->setLength(200);
$table->addColumn($col);

$col = new base_install_Column('tcpAddress');
$col->setType(base_install_Column::VARCHAR)->setLength(200);
$table->addColumn($col);

$col = new base_install_Column('tcpName');
$col->setType(base_install_Column::VARCHAR)->setLength(200);
$table->addColumn($col);

$col = new base_install_Column('regTime');
$col->setType(base_install_Column::DATETIME)->setDefault(base_install_Column::CURRENT_TIMESTAMP);
$table->addColumn($col);

$col = new base_install_Column('regAdmin');
$col->setType(base_install_Column::VARCHAR)->setLength(40);
$table->addColumn($col);

$col = new base_install_Column('FK_collocgroup');
$col->setType(base_install_Column::INT)->setNull();
$table->addColumn($col);

$col = new base_install_Column('FK_domain');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$col = new base_install_Column('lastAccessTime');
$col->setType(base_install_Column::DATETIME)->setDefault(base_install_Column::CURRENT_TIMESTAMP);
$table->addColumn($col);

$col = new base_install_Column('lastCommMeth');
$col->setType(base_install_Column::INT)->setLength(40);
$table->addColumn($col);

$col = new base_install_Column('lastCommWait');
$col->setType(base_install_Column::INT)->setLength(40);
$table->addColumn($col);

$col = new base_install_Column('lastDuration');
$col->setType(base_install_Column::INT)->setLength(40);
$table->addColumn($col);

$col = new base_install_Column('lastIdleWait');
$col->setType(base_install_Column::INT)->setLength(40);
$table->addColumn($col);

$col = new base_install_Column('lastMediaWait');
$col->setType(base_install_Column::INT)->setLength(40);
$table->addColumn($col);

$col = new base_install_Column('lastReceived');
$col->setType(base_install_Column::INT)->setLength(40);
$table->addColumn($col);

$col = new base_install_Column('lastSent');
$col->setType(base_install_Column::INT)->setLength(40);
$table->addColumn($col);

$col = new base_install_Column('FK_tsmserver');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$manager->addTable($table);

/** --------------- table tsmdomain ---------------*/
$table = new base_install_table_BaseObject('tsmdomain');

$col = new base_install_Column('name');
$col->setType(base_install_Column::VARCHAR)->setLength(200);
$table->addColumn($col);

$col = new base_install_Column('FK_tsmserver');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$manager->addTable($table);

/** --------------- table tsmcollocgroup ---------------*/
$table = new base_install_table_BaseObject('tsmcollocgroup');

$col = new base_install_Column('name');
$col->setType(base_install_Column::VARCHAR)->setLength(200);
$table->addColumn($col);

$col = new base_install_Column('FK_tsmserver');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$manager->addTable($table);

/** --------------- table tsmsummary ---------------*/
$table = new base_install_table_BaseObject('tsmsummary');

$col = new base_install_Column('nodeName');
$col->setType(base_install_Column::VARCHAR)->setLength(200);
$table->addColumn($col);

$col = new base_install_Column('subEntity');
$col->setType(base_install_Column::VARCHAR)->setLength(200)->setNull();
$table->addColumn($col);

$col = new base_install_Column('successful');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$col = new base_install_Column('bytes');
$col->setType(base_install_Column::INT)->setNull()->setDefault(0);
$table->addColumn($col);

$col = new base_install_Column('examined');
$col->setType(base_install_Column::INT)->setNull()->setDefault(0);
$table->addColumn($col);

$col = new base_install_Column('affected');
$col->setType(base_install_Column::INT)->setNull()->setDefault(0);
$table->addColumn($col);

$col = new base_install_Column('startTime');
$col->setType(base_install_Column::DATETIME);
$table->addColumn($col);

$col = new base_install_Column('failed');
$col->setType(base_install_Column::INT)->setNull()->setDefault(0);
$table->addColumn($col);

$col = new base_install_Column('FK_tsmserver');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$manager->addTable($table);