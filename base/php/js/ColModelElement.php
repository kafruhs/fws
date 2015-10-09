<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.02.2015
 * Time: 15:40
 */

class base_js_ColModelElement 
{
    const FORMATTER_DATE = 'date';

    const FORMATTER_NUMBER = 'number';

    const FORMATTER_CURRENCY = 'currency';

    const FORMATTER_INTEGER = 'integer';

    const EDITTYPE_CHECKBOX = 'checkbox';

    const EDITTYPE_SELECT = 'select';

    const EDITTYPE_DATE = 'date';

    const EDITTYPE_TEXTAREA = 'textarea';

    const ALIGN_LEFT = 'left';

    const ALIGN_CENTER = 'center';

    const ALIGN_RIGHT = 'right';


    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $index;

    /**
     * @var int
     */
    protected $width = 'auto';

    /**
     * @var bool
     */
    protected $editable = 'false';

    /**
     * @var string
     */
    protected $edittype;

    /**
     * @var string
     */
    protected $formatter;

    /**
     * @var array
     */
    protected $formatoptions = array();

    /**
     * @var array
     */
    protected $editOptions = array();

    protected $align = self::ALIGN_LEFT;

    /**
     * additional class-tags for each cell on a column. Class names must be divided by " "
     *
     * @var string
     */
    protected $classes;

    /**
     * @param string $classes
     * @return $this
     */
    public function setClasses($classes)
    {
        if (!isset($this->classes)) {
            $this->classes = $classes;
        } else {
            $this->classes .= $classes;
        }

        return $this;
    }

    /**
     * @param string $align
     * @return $this
     * @throws base_exception_JS
     */
    public function setAlign($align)
    {
        $validAligns = array(
            self::ALIGN_CENTER,
            self::ALIGN_LEFT,
            self::ALIGN_RIGHT
        );
        if (!in_array($align, $validAligns)) {
            throw new base_exception_JS(TMS(base_exception_JS::WRONG_ALIGN_VALUE));
        }
        $this->align = $align;
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $index
     * @return $this
     */
    public function setIndex($index)
    {
        $this->index = $index;
        return $this;
    }

    /**
     * @param int $width
     * @return $this
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return $this
     */
    public function setEditableTrue()
    {
        $this->editable = 'true';
        return $this;
    }

    /**
     * @param $optionName
     * @param $value
     * @return $this
     */
    public function setEditOptions($optionName, $value)
    {
        $this->editOptions[$optionName] = $value;
        return $this;
    }

    /**
     * @param string $edittype
     */
    public function setEdittype($edittype)
    {
        if (!in_array($edittype, array(self::EDITTYPE_CHECKBOX, self::EDITTYPE_DATE, self::EDITTYPE_SELECT, self::EDITTYPE_TEXTAREA))) {
            throw new base_exception_JS(TMS(base_exception_JS::WRONG_EDITTYPE));
        }
        $this->edittype = $edittype;

        if ($edittype == self::EDITTYPE_DATE) {
            $this->edittype = 'text';
            $this->setEditOptions('dataInit', "function(element) { $(element).datepicker({dateFormat: 'dd.mm.YY' })}");
            $this->setEditOptions('size', 15);
            $this->setEditOptions('maxLength', 10);
        }
    }



    /**
     * get the edit option in correct format
     *
     * @return string
     */
    protected function getFormatedEditOption()
    {
        $editOptions = [];
        foreach ($this->editOptions as $name => $value) {
            $editOptions[] = $name . ':' . $value;
        }

        return "{" . implode(',', $editOptions) . "}";
    }

    /**
     * @param string $formatter
     * @return $this
     * @throws base_exception_JS
     */
    public function setFormatter($formatter)
    {
        $validFormatter = array(
            self::FORMATTER_INTEGER,
            self::FORMATTER_DATE,
            self::FORMATTER_NUMBER,
            self::FORMATTER_CURRENCY
        );
        if (!in_array($formatter, $validFormatter)) {
            throw new base_exception_JS(TMS(base_exception_JS::WRONG_FORMATER_VALUE));
        }
        $this->formatter = $formatter;
        return $this;
    }

    /**
     * @param array $formatoptions
     * @return $this
     */
    public function setFormatoptions(array $formatoptions)
    {
        $this->formatoptions = $formatoptions;
        return $this;
    }

    /**
     * @return string
     */
    protected function getFormatedFormatOptions()
    {
        if (!isset($this->formatter)) {
            return '';
        }

        $formatter = '';
        switch ($this->formatter) {
            case self::FORMATTER_DATE:
                $formatter = "formatoptions: {srcformat: 'd.m.Y H:i', newformat: 'd.m.Y, H:i'},sorttype:'date'";
                break;
            case self::FORMATTER_NUMBER:
                $formatter = 'formatoptions: {decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 2, defaultValue: "0,00"}, sorttype:"number"';
                break;
            case self::FORMATTER_CURRENCY:
                $formatter = 'formatoptions: {decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 2,prefix:"",suffix:" €",defaultValue: "0,00"},sorttype:"currency"';
                break;
            case self::FORMATTER_INTEGER:
                $formatter = 'formatoptions: {thousandsSeparator: ".", defaultValue: "0"},sorttype:"int"';
                break;
            default:
                break;
        }
        return "formatter:'{$this->formatter}',$formatter,";
    }

    public function toString()
    {
        $output = "{name:'{$this->name}',index:'{$this->index}',width:'{$this->width}',";
        $output .= $this->getFormatedFormatOptions();
        $output .= "align:'{$this->align}',";
        $output .= "editable:$this->editable";
        if (!empty($this->edittype)) {
            $output .= ",edittype:'{$this->edittype}'";
        }
        if (!empty($this->editOptions) && $this->editable == 'true') {
            $output .= ',editoptions:' . $this->getFormatedEditOption();
        }
        if (!empty($this->classes)) {
            $output .= ",classes: '{$this->classes}'";
        }
        $output .= '}';
        return $output;
    }




}