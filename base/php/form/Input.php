<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.01.2015
 * Time: 12:12
 */

abstract class base_form_Input
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var string
     */
    protected $class = 'inputelement';

    /**
     * @var string
     */
    protected $id;

    /**
     * @var bool
     */
    protected $multiline = false;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $displayMode;

    /**
     * @var int
     */
    protected $maxlength;

    /**
     * @var Fieldinfo
     */
    protected $fieldinfo;

    /**
     * width of the element
     *
     * @var int
     */
    protected $displayedLength;

    public function __construct(Fieldinfo $fieldinfo)
    {
        $this->fieldinfo = $fieldinfo;
        $this->addClass();
    }

    protected function addClass()
    {
        $this->class .= ' non-specific';

    }

    /**
     * @return mixed
     */
    public function getMaxlength()
    {
        return $this->maxlength;
    }

    /**
     * @param mixed $maxlength
     */
    public function setMaxlength($maxlength)
    {
        $this->maxlength = $maxlength;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return boolean
     */
    public function isMultiline()
    {
        return $this->multiline;
    }

    /**
     */
    public function setMultiline()
    {
        $this->multiline = true;
    }

    /**
     * @return string
     */
    public function getDisplayMode()
    {
        return $this->displayMode;
    }

    /**
     * @return int
     */
    public function getDisplayedLength()
    {
        return $this->displayedLength;
    }

    /**
     * @param int $displayedLength
     */
    public function setDisplayedLength($displayedLength)
    {
        $this->displayedLength = $displayedLength;
    }

    /**
     * @param $displayMode string
     */
    public function setDisplayMode($displayMode)
    {
        if (!in_array($displayMode, array(DisplayClass::VIEW, DisplayClass::EDIT, DisplayClass::HIDE))) {
            $this->displayMode = DisplayClass::VIEW;
        } else {
            $this->displayMode = $displayMode;
        }
    }

    public function display()
    {
        if (!isset($this->displayMode) || $this->displayMode == DisplayClass::VIEW) {
            return $this->getReadOnlyDisplay();
        } elseif ($this->displayMode == DisplayClass::EDIT) {
            return $this->getWriteDisplay();
        } else {
            $hidden = new base_form_element_Hidden(new Fieldinfo('BaseObject'));
            $hidden->setName($this->getName());
            if ($this->isMultiline())  {
                $hidden->setMultiline();
            }
            $hidden->setValue($this->getValue());
            return $hidden->display();
        }
    }

    /**
     * show the data without input element, because editing is not possible
     *
     * @return string
     */
    abstract protected function getReadOnlyDisplay();

    /**
     * show the data in n input element for editing
     *
     * @return string
     */
    abstract protected function getWriteDisplay();

}