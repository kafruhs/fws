<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.01.2015
 * Time: 13:30
 */

class base_form_element_Lk extends base_form_element_Alphanumeric
{
    protected $size = 5;


    /**
     *
     */
    protected function addClass()
    {
        $this->class .= ' lk';
    }

    protected function getWriteDisplay()
    {
        $fi = $this->fieldinfo;
        $class = $fi->getConnectedClass();
        $connectedField = $fi->getFieldsOfConnectedClass();
        $objs = Finder::create($class)->find();
        $output = Html::startTag('select', array('class' => $this->class, 'name' => $this->name));
        foreach ($objs as $obj) {
            $params = [];
            $actualFieldValue = $obj[$connectedField];
            if ($this->value == $actualFieldValue) {
                $params['selected'] = 'selected';
            }
            $params['value'] = $obj->getLogicalKey();
            $output .= Html::startTag('option', $params) . $actualFieldValue . Html::endTag('option');
        }
        $output .= Html::endTag('select');
        return $output;
    }


}