<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.01.2015
 * Time: 10:26
 */

$manager = base_install_Manager::get();

/** --------------- table fieldinfo ---------------*/
$table = new base_install_Table('fieldinfo');

$col = new base_install_Column('PK');
$col->setType(base_install_Column::INT)->setPrimary()->setAutoIncrement();
$table->addColumn($col);

$col = new base_install_Column('class');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('fieldName');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('fieldLabel');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('dataType');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('mandatory');
$col->setType(base_install_Column::VARCHAR)->setLength(1);
$table->addColumn($col);

$col = new base_install_Column('maxLength');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$col = new base_install_Column('displayedLength');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$col = new base_install_Column('displayClass');
$col->setType(base_install_Column::VARCHAR)->setLength(400)->setNull();
$table->addColumn($col);

$col = new base_install_Column('defaultValue');
$col->setType(base_install_Column::VARCHAR)->setLength(400)->setNull();
$table->addColumn($col);

$col = new base_install_Column('connectedClass');
$col->setType(base_install_Column::VARCHAR)->setLength(400)->setNull();
$table->addColumn($col);

$col = new base_install_Column('fieldsOfConnectedClass');
$col->setType(base_install_Column::VARCHAR)->setLength(400)->setNull();
$table->addColumn($col);

$col = new base_install_Column('selectionlistName');
$col->setType(base_install_Column::VARCHAR)->setLength(400)->setNull();
$table->addColumn($col);

$manager->addTable($table);

/** --------------- table user ---------------*/
$table = new base_install_table_BaseObject('user');

$col = new base_install_Column('lastLogin');
$col->setType(base_install_Column::DATETIME)->setNull();
$table->addColumn($col);

$col = new base_install_Column('loginTries');
$col->setType(base_install_Column::INT)->setDefault(0);
$table->addColumn($col);

$col = new base_install_Column('disabled');
$col->setType(base_install_Column::VARCHAR)->setLength(2)->setDefault('N')->setNull();
$table->addColumn($col);

$col = new base_install_Column('ip');
$col->setType(base_install_Column::VARCHAR)->setLength(40)->setNull();
$table->addColumn($col);

$col = new base_install_Column('sessionid');
$col->setType(base_install_Column::VARCHAR)->setLength(40)->setNull();
$table->addColumn($col);

$col = new base_install_Column('userid');
$col->setType(base_install_Column::VARCHAR)->setLength(30);
$table->addColumn($col);

$col = new base_install_Column('password');
$col->setType(base_install_Column::VARCHAR)->setLength(40);
$table->addColumn($col);

$col = new base_install_Column('showPrivateData');
$col->setType(base_install_Column::VARCHAR)->setLength(2)->setDefault('N')->setNull();
$table->addColumn($col);

$col = new base_install_Column('firstName');
$col->setType(base_install_Column::VARCHAR)->setLength(100);
$table->addColumn($col);

$col = new base_install_Column('lastName');
$col->setType(base_install_Column::VARCHAR)->setLength(100);
$table->addColumn($col);

$col = new base_install_Column('email');
$col->setType(base_install_Column::VARCHAR)->setLength(200);
$table->addColumn($col);

$col = new base_install_Column('homepage');
$col->setType(base_install_Column::VARCHAR)->setLength(200)->setNull();
$table->addColumn($col);

$col = new base_install_Column('city');
$col->setType(base_install_Column::VARCHAR)->setLength(200)->setNull();
$table->addColumn($col);

$col = new base_install_Column('postalCode');
$col->setType(base_install_Column::INT)->setLength(5)->setNull();
$table->addColumn($col);

$col = new base_install_Column('street');
$col->setType(base_install_Column::VARCHAR)->setLength(200)->setNull();
$table->addColumn($col);

$manager->addTable($table);

/** --------------- table TMS ---------------*/
$table = new base_install_Table('tms');

$col = new base_install_Column('PK');
$col->setType(base_install_Column::INT)->setPrimary()->setAutoIncrement();
$table->addColumn($col);

$col = new base_install_Column('de');
$col->setType(base_install_Column::TEXT);
$table->addColumn($col);

$col = new base_install_Column('en');
$col->setType(base_install_Column::TEXT);
$table->addColumn($col);

$col = new base_install_Column('name');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$manager->addTable($table);

/** --------------- table Selectionlist ---------------*/
$table = new base_install_Table('selectionList');

$col = new base_install_Column('PK');
$col->setType(base_install_Column::INT)->setPrimary()->setAutoIncrement();
$table->addColumn($col);

$col = new base_install_Column('identifier');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('name');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$manager->addTable($table);

/** --------------- table SelectionlistEntry ---------------*/
$table = new base_install_Table('selectionListEntry');

$col = new base_install_Column('PK');
$col->setType(base_install_Column::INT)->setPrimary()->setAutoIncrement();
$table->addColumn($col);

$col = new base_install_Column('name');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('FK_selectionList');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$manager->addTable($table);

/** --------------- table Sequence ---------------*/
$table = new base_install_Table('sequence');

$col = new base_install_Column('PK');
$col->setType(base_install_Column::INT)->setPrimary()->setAutoIncrement();
$table->addColumn($col);

$col = new base_install_Column('class');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('num');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$manager->addTable($table);

/** --------------- table group ---------------*/
$table = new base_install_table_BaseObject('gruppe');

$col = new base_install_Column('name');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$manager->addTable($table);

/** --------------- table permission ---------------*/
$table = new base_install_table_BaseObject('permission');

$col = new base_install_Column('name');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$manager->addTable($table);

/** --------------- table file ---------------*/
$table = new base_install_table_BaseObject('file');

$col = new base_install_Column('name');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('link');
$col->setType(base_install_Column::TEXT);
$table->addColumn($col);

$col = new base_install_Column('description');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$manager->addTable($table);

/** --------------- table group$right ---------------*/
$table = new base_install_table_BaseConnectionObject('group$right');

$manager->addTable($table);

/** --------------- table user$group ---------------*/
$table = new base_install_table_BaseConnectionObject('user$group');

$manager->addTable($table);

/** --------------- table connectionObjects -------------- */
$table = new base_install_table_BaseConnectionObject('connectionObjects');

$manager->addTable($table);

/** --------------- table navigationCategory ---------------*/
$table = new base_install_table_BaseObject('navigationCategory');

$col = new base_install_Column('name');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('sort');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$manager->addTable($table);


/** --------------- table navigationEntry ---------------*/
$table = new base_install_table_BaseObject('navigationEntry');

$col = new base_install_Column('name');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('url');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('permission');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$col = new base_install_Column('category');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$col = new base_install_Column('sort');
$col->setType(base_install_Column::INT);
$table->addColumn($col);

$manager->addTable($table);

/** --------------- table News ---------------*/
$table = new base_install_table_BaseObject('news');

$col = new base_install_Column('title');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('content');
$col->setType(base_install_Column::TEXT);
$table->addColumn($col);

$manager->addTable($table);

/** --------------- table datapermission ---------------*/
$table = new base_install_Table('datapermission');

$col = new base_install_Column('PK');
$col->setAutoIncrement()->setPrimary()->setType(base_install_Column::INT);
$table->addColumn($col);

$col = new base_install_Column('objClass');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$col = new base_install_Column('dpClass');
$col->setType(base_install_Column::VARCHAR)->setLength(400);
$table->addColumn($col);

$manager->addTable($table);