<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.01.2015
 * Time: 17:35
 */

class base_form_element_Submit extends base_form_element_Alphanumeric
{
    protected $type = 'submit';

    protected $name = 'submit';

    protected $value = 'Speichern';

    protected $class = 'submitButton';

    protected $formaction;

    /**
     * @return string
     */
    public function getFormaction()
    {
        return $this->formaction;
    }

    /**
     * @param string $formaction
     */
    public function setFormaction($formaction)
    {
        $this->formaction = $formaction;
    }

    public function display()
    {
        return $this->getWriteDisplay();
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
        if (isset($this->formaction)) {
            $params['formaction'] = $this->formaction;
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