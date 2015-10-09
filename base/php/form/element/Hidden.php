<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.01.2015
 * Time: 13:44
 */

class base_form_element_Hidden extends base_form_element_Alphanumeric
{
    protected $type = 'hidden';

    public function display()
    {
        /** css */
        $params['class'] = $this->class;
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