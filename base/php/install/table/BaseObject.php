<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.01.2015
 * Time: 12:22
 */

class base_install_table_BaseObject extends base_install_Table
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

        $col = new base_install_Column('LK');
        $col->setType(base_install_Column::INT);
        $this->addColumn($col);

        $col = new base_install_Column('histtop');
        $col->setType(base_install_Column::VARCHAR)->setLength(2)->setDefault('Y');
        $this->addColumn($col);

        $col = new base_install_Column('editTime');
        $col->setType(base_install_Column::DATETIME);
        $this->addColumn($col);

        $col = new base_install_Column('editor');
        $col->setType(base_install_Column::INT);
        $this->addColumn($col);

        $col = new base_install_Column('firstEditTime');
        $col->setType(base_install_Column::DATETIME);
        $this->addColumn($col);

        $col = new base_install_Column('firstEditor');
        $col->setType(base_install_Column::INT);
        $this->addColumn($col);
    }
}