<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 09.11.2014
 * Time: 19:55
 */

class base_html_model_table_Cell
{
    const ROWTAG_BODY = 'tr';

    const ROWTAG_HEAD = 'th';

    /**
     * @var string
     */
    protected $cssClass = 'cell';

    /**
     * @var string
     */
    protected $cssID;

    /**
     * @var string
     */
    protected $content = '';

    /**
     * @var int
     */
    protected $colSpan;

    /**
     * @var int
     */
    protected $rowSpan;

    /**
     * @var string
     */
    protected $cellType = self::ROWTAG_BODY;

    /**
     * @var array
     */
    protected $attributes = array();

    /**
     * @return string
     */
    public function getCellType()
    {
        return $this->cellType;
    }

    /**
     * @param string $cellType
     */
    public function setCellType($cellType)
    {
        $this->cellType = $cellType;
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
    public function getCssID()
    {
        return $this->cssID;
    }

    /**
     * @param string $cssID
     */
    public function setCssID($cssID)
    {
        $this->cssID = $cssID;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getColSpan()
    {
        return $this->colSpan;
    }

    /**
     * @param int $colSpan
     * @throws base_html_model_Exception
     */
    public function setColSpan($colSpan)
    {
        if (!is_int($colSpan)) {
            throw new base_html_model_Exception(TMS(base_html_model_Exception::NO_INT_VALUE));
        }
        $this->colSpan = $colSpan;
    }

    /**
     * @param int $rowSpan
     * @throws base_html_model_Exception
     */
    public function setRowSpan($rowSpan)
    {
        if (!is_int($rowSpan)) {
            throw new base_html_model_Exception(TMS(base_html_model_Exception::NO_INT_VALUE));
        }
        $this->colSpan = $rowSpan;
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

    public function toString()
    {
        $this->attributes['class'] = $this->cssClass;

        if (isset($this->colSpan)) {
            $this->attributes['colspan'] = $this->colSpan;
        }

        if (isset($this->rowSpan)) {
            $this->attributes['rowspan'] = $this->rowSpan;
        }

        if (isset($this->cssID)) {
            $this->attributes['id'] = $this->cssID;
        }

        $td  = Html::startTag($this->cellType, $this->attributes);
        $td .= $this->content;
        $td .= Html::endTag($this->cellType);

        return $td;
    }

}