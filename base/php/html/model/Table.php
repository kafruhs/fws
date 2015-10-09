<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 09.11.2014
 * Time: 19:48
 */

class base_html_model_Table
{
    /**
     * @var base_html_model_table_Row[]
     */
    protected $rows = array();

    /**
     * @var base_html_model_table_Row
     */
    protected $headRow;
    /**
     * @var string
     */
    protected $cssClass = 'table';

    /**
     * @var string
     */
    protected $cssID;

    /**
     * @var array
     */
    protected $attributes = array();

    /**
     * @return base_html_model_table_Row
     */
    public function getHeadRow()
    {
        return $this->headRow;
    }

    /**
     * @param base_html_model_table_Row $headRow
     */
    public function addHeadRow(base_html_model_table_Row $headRow)
    {
        $this->headRow = $headRow;
        $this->headRow->setRowType(base_html_model_table_Row::ROWTAG_HEAD);
    }

    /**
     * @return string
     */
    public function getCssClass()
    {
        return $this->cssClass;
    }

    /**
     * @param string $cssClass
     */
    public function setCssClass($cssClass)
    {
        $this->cssClass = $cssClass;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->cssID;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->cssID = $id;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return array base_html_model_table_Row[]
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @param base_html_model_table_Row $row
     */
    public function addRow(base_html_model_table_Row $row)
    {
        if (count($this->rows) % 2) {
            $row->setClass($row->getClass() . ' oddRow');
        }
        $this->rows[] = $row;
    }

    public function toString()
    {
        $this->attributes['class'] = $this->cssClass;

        if (isset($this->cssID)) {
            $this->attributes['id'] = $this->cssID;
        }

        $table  = Html::startTag('table', $this->attributes);

        if (isset($this->headRow)) {
            $table .= Html::startTag('thead') . $this->headRow->toString() . Html::endTag('thead');
        }

        if (!empty($this->rows)) {
            $table .= Html::startTag('tbody');
            foreach ($this->rows as $row) {
                $table .= $row->toString();
            }
            $table .= Html::endTag('tbody');
        }

        $table .= Html::endTag('table');
        return $table;
    }


}