<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.01.2015
 * Time: 13:30
 */

class base_form_element_Currency extends base_form_element_Alphanumeric
{
    protected $size = 5;

    protected function addClass()
    {
        $this->class .= ' currency';
    }

    /**
     * show the data without input element, because editing is not possible
     *
     * @return string
     */
    protected function getReadOnlyDisplay()
    {
        return Html::startTag('div', array('class' => $this->class . ' formWidth' . $this->displayedLength)) .  $this->value . ' &euro;' . Html::endTag('div');
    }

    protected function getWriteDisplay()
    {
        return parent::getWriteDisplay() . " &euro;";
    }


}