<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 15.01.2015
 * Time: 07:46
 */

class base_form_element_Text extends base_form_Input
{

    protected $rows = 5;

    protected $cols = 25;

    /**
     * @return int
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @param int $rows
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
    }

    /**
     * @return int
     */
    public function getCols()
    {
        return $this->cols;
    }

    /**
     * @param int $cols
     */
    public function setCols($cols)
    {
        $this->cols = $cols;
    }

    /**
     * show the data without input element, because editing is not possible
     *
     * @return string
     */
    protected function getReadOnlyDisplay()
    {
        return $this->getValue();
    }

    /**
     * show the data in n input element for editing
     *
     * @return string
     */
    protected function getWriteDisplay()
    {
        $params['name'] = $this->getName();
        if (!empty($this->id)) {
            $params['id'] = $this->id;

        }
        if (!empty($this->class)) {
            $params['class'] = $this->class;
        }
        $params['cols'] = $this->cols;
        $params['rows'] = $this->rows;

        $textArea = Html::startTag('textarea', $params);
        if (!empty($this->value)) {
            $textArea .= $this->getValue();
        }
        $textArea .= Html::endTag('textarea');
        return $textArea;

    }
}