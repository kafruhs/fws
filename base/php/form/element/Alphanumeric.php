<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.01.2015
 * Time: 12:29
 */

class base_form_element_Alphanumeric extends base_form_Input
{
    protected $type = 'text';

    /**
     * @var int
     */
    protected $size;

    /**
     *
     */
    protected function addClass()
    {
        $this->class .= ' alphanumeric';
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * show the data without input element, because editing is not possible
     *
     * @return string
     */
    protected function getReadOnlyDisplay()
    {
        return Html::startTag('div', array('class' => $this->class. ' formWidth' . $this->displayedLength)) . $this->value . Html::endTag('div');
    }

    /**
     * show the data in an input element for editing
     *
     * @return string
     */
    protected function getWriteDisplay()
    {
        /** css */
        $params['class'] = $this->class . ' formWidth' . $this->displayedLength;
        if (isset($this->id)) {
            $params['id'] = $this->id;
        }

        if ($this->isMultiline()) {
            $this->name .= '[]';
        }
        $params['name'] = $this->name;
        $params['type'] = $this->type;
        if (isset($this->size)) {
            $params['size'] = $this->size;
        }
        if (isset($this->maxlength)) {
            $params['maxlength'] = $this->maxlength;
        }
        if (isset($this->value)) {
            $params['value'] = $this->value;
        }


        return Html::singleTag('input', $params);
    }
}