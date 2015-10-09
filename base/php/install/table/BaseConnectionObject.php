<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.01.2015
 * Time: 12:22
 */

class base_install_table_BaseConnectionObject extends base_install_Table
{
    public function __construct($tableName)
    {
        parent::__construct($tableName);
        $this->_setBaseColumns();
    }

    private function _setBaseColumns()
    {
        $col = new base_install_Column('PK');
        $col->setType(base_install_Column::INT)->setPrimary()->setAutoIncrement();
        $this->addColumn($col);

        $col = new base_install_Column('classLeft');
        $col->setType(base_install_Column::VARCHAR)->setLength(400);
        $this->addColumn($col);

        $col = new base_install_Column('lkLeft');
        $col->setType(base_install_Column::INT);
        $this->addColumn($col);

        $col = new base_install_Column('lkRight');
        $col->setType(base_install_Column::INT);
        $this->addColumn($col);

        $col = new base_install_Column('classRight');
        $col->setType(base_install_Column::VARCHAR)->setLength(400);
        $this->addColumn($col);
    }
}