<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 11.11.2014
 * Time: 20:11
 */

class base_html_model_Form
{
    const WRONG_SUBMIT_CALL = 'base.form.wrongSubmitCall';

    /**
     * @param $action
     * @param string $method
     * @param array $attributes
     * @return string
     */
    public function start($action, $method = 'post', $attributes = array())
    {
        $attributes['action'] = $action;
        $attributes['method'] = $method;
        return Html::startTag('form', $attributes);
    }

    /**
     * @param $name
     * @param string $value
     * @param array $attributes
     * @return string
     */
    public function textInput($name, $value = '', $attributes = array())
    {
        $attributes['name'] = $name;
        $attributes['value'] = $value;

        $attributes = Html::extendAttributeIfExists('class', 'textInput', $attributes);

        return $this->_input($attributes);
    }

    /**
     * @param $name
     * @param array $attributes
     * @return string
     */
    public function passwordInput($name, $attributes = array())
    {
        $attributes['name'] = $name;
        $attributes['type'] = 'password';

        $attributes = Html::extendAttributeIfExists('class', 'textInput', $attributes);

        return $this->_input($attributes);
    }

    /**
     * @param $name
     * @param $value
     * @param array $attributes
     * @return string
     */
    public function submitButton($name, $value, $attributes = array())
    {
        $attributes['name'] = $name;
        $attributes['type'] = 'submit';
        $attributes['value'] = $value;
        $attributes = Html::extendAttributeIfExists('class', 'submitButton', $attributes);

        return $this->_input($attributes);
    }

    /**
     * @param $name
     * @param string $value
     * @param int $cols
     * @param int $rows
     * @param array $attributes
     * @return string
     */
    public function textArea($name, $value = '', $cols = 30, $rows = 150, $attributes = array())
    {
        $attributes['name'] = $name;
        $attributes['value'] = $value;
        $attributes['cols'] = $cols;
        $attributes['rows'] = $rows;
        $textArea = Html::startTag('textarea', $attributes);
        $textArea .= $value;
        $textArea .= Html::endTag('textarea');
        return $textArea;
    }

    /**
     * displays a checkbox
     *
     * @param $name
     */
    public function checkboxInput($name, $value = 1, $checked = false, $label = null)
    {
        if ($checked == true) {
            $attributes['checked'] = 'checked';
        }
        $attributes['type'] = 'checkbox';
        $attributes['name'] = $name;
        $attributes['value'] = $value;
        $checkbox = $this->_input($attributes);

        if (is_null($label) === false) {
            $checkbox .= " $label";
        }
        return $checkbox;
    }

    /**
     * @param $name
     * @param array $options
     * @return string
     */
    public function multiCheckbox($name, array $options)
    {
        $multiBox = '';
        foreach ($options as $option) {
            $multiBox .= Html::startTag('p', array('class' => 'multiCheckbox'));
            $multiBox .= $this->checkboxInput($name . '[]', $option['value'], $option['checked'], $option['label']);
            $multiBox .= Html::endTag('p');
        }

        return $multiBox;
    }

    /**
     * @return string
     */
    public function end()
    {
        return Html::endTag('form');
    }

    public function label($name, $inputName, $attributes = array())
    {
        $id = "label_$inputName";
        $attributes = Html::extendAttributeIfExists('id', $id, $attributes);
        $attributes = Html::extendAttributeIfExists('class', 'label', $attributes);
        $label = Html::startTag('span', $attributes);
        $label .= $name;
        $label .= Html::endTag('span');
        return $label;
    }

    /**
     * @param $attributes
     * @return string
     */
    private function _input($attributes)
    {
        return Html::singleTag('input', $attributes);
    }
}