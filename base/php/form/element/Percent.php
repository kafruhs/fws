<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.01.2015
 * Time: 12:29
 */

class base_form_element_Percent extends base_form_element_Numeric
{
    protected $type = 'text';

    /**
     *
     */
    protected function addClass()
    {
        $this->class .= ' percent';
    }

    /**
     * show the data without input element, because editing is not possible
     *
     * @return string
     */
    protected function getReadOnlyDisplay()
    {
        return Html::startTag('div', array('class' => $this->class. ' formWidth' . $this->displayedLength)) . $this->value . " %" . Html::endTag('div');
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


        return Html::singleTag('input', $params) . " %";
    }
}