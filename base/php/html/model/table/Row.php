<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 09.11.2014
 * Time: 20:09
 */

class base_html_model_table_Row
{
    const ROWTAG_BODY = 'td';

    const ROWTAG_HEAD = 'th';

    /**
     * @var string
     */
    protected $cssClass = 'row';

    /**
     * @var
     */
    protected $cssID;

    /**
     * @var base_html_model_table_Cell[]
     */
    protected $cells = array();

    /**
     * @var array
     */
    protected $attributes = array();

    /**
     * @var string
     */
    protected $rowType = self::ROWTAG_BODY;

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->cssClass;
    }

    /**
     * @param string $class
     */
    public function setClass($class)
    {
        $this->cssClass = $class;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->cssID;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->cssID = $id;
    }

    /**
     * @return base_html_model_table_Cell[]
     */
    public function getCells()
    {
        return $this->cells;
    }

    /**
     * @param base_html_model_table_Cell $cell
     */
    public function addCell(base_html_model_table_Cell $cell)
    {
        $this->cells[] = $cell;
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
     * @return string
     */
    public function getRowType()
    {
        return $this->rowType;
    }

    /**
     * @param string $rowType
     * @throws base_html_model_Exception
     */
    public function setRowType($rowType)
    {
        if (!in_array($rowType, array(self::ROWTAG_BODY, self::ROWTAG_HEAD))) {
            throw new base_html_model_Exception(TMS(base_html_model_Exception::NO_VALID_ROWTYPE, array('type' => $rowType)));
        }
        $this->rowType = $rowType;
    }

    /**
     *
     */
    public function toString()
    {
        $this->attributes['class'] = $this->cssClass;

        if (isset($this->cssID)) {
            $this->attributes['id'] = $this->cssID;
        }

        $tr  = Html::startTag('tr', $this->attributes);
        foreach ($this->getCells() as $cell) {
            if ($this->rowType) {
                $cell->setCellType($this->rowType);
            }
            $tr .= $cell->toString();
        }
        $tr .= Html::endTag('tr');
        return $tr;
    }
}