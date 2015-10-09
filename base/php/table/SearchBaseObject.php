<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.01.2015
 * Time: 16:23
 */

class base_table_SearchBaseObject
{
    /**
     * @var BaseObject
     */
    protected $obj;

    /**
     * @var BaseObject[]
     */
    protected $rowContent;

    /**
     * @var array
     */
    protected $cols;

    public function __construct(BaseObject $obj)
    {
        $this->obj = $obj;
    }

    /**
     * @return mixed
     */
    public function getRowContent()
    {
        return $this->rowContent;
    }

    /**
     * @param array $rows
     */
    public function setRowContent(array $rows)
    {
        $this->rowContent = $rows;
    }

    /**
     * @return mixed
     */
    public function getCols()
    {
        return $this->cols;
    }

    /**
     * @param mixed $cols
     */
    public function setCols($cols)
    {
        $this->cols = $cols;
    }

    public function toString()
    {
        $htmlTable = new base_html_model_Table();
        $htmlTable->setId('searchTable');
        $headRow = $this->createHeadRow();
        $htmlTable->addHeadRow($headRow);
        foreach ($this->rowContent as $obj) {
            $row = new base_html_model_table_Row();
            foreach ($this->cols as $columnName) {
                $cell = new base_html_model_table_Cell();
                $cell->setContent($obj->getField($columnName));
                $row->addCell($cell);
            }
            $htmlTable->addRow($row);
        }
        return $htmlTable->toString();
    }

    /**
     * @return base_html_model_table_Row
     */
    protected function createHeadRow()
    {
        $headRow = new base_html_model_table_Row();
        $headRow->setClass('headerRow');
        foreach ($this->cols as $columnName) {
            $cell = new base_html_model_table_Cell();
            $cell->setContent($this->obj->getFieldinfo($columnName)->getFieldLabel());
            $headRow->addCell($cell);
        }
        return $headRow;
    }
}