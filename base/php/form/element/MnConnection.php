<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.01.2015
 * Time: 12:29
 */

class base_form_element_MnConnection extends base_form_Input
{
    protected $class = 'mnConnection';
    /**
     * show the data without input element, because editing is not possible
     *
     * @return string
     */
    protected function getReadOnlyDisplay()
    {
        return Html::startTag('div', array('class' => $this->class)) . $this->value . Html::endTag('div');
    }

    /**
     * show the data in an input element for editing
     *
     * @return string
     */
    protected function getWriteDisplay()
    {
        $selectedOptionNames = explode(', ', $this->value);
        $output = Html::startTag('div', ['class' => $this->class]);
        $connectedClassName = $this->fieldinfo->getConnectedClass();
        /** @var BaseConnectionObject $connObj */
        $connObj = new $connectedClassName();
        $class = $connObj->getOtherClass($this->fieldinfo->getClass());
        $obj = Factory::createObject($class);
        $connectedFieldName = $this->fieldinfo->getFieldsOfConnectedClass();
        $table = DB::table($obj->getTable());
        $result = Finder::create($class)->find([$table->getColumn($connectedFieldName), $table->getColumn('LK')]);
        foreach ($result as $row) {
            $params = [];
            $params['value'] = $row['LK'];
            $params['type']  = 'checkbox';
            $params['class'] = 'checkbox';
            $params['name']  = $this->name . '[]';
            if (in_array($row[$connectedFieldName], $selectedOptionNames)) {
                $params['checked'] = 'checked';
            }
            $output .= Html::startTag('p') . Html::singleTag('input', $params) . " " . $row[$connectedFieldName] . Html::endTag('p');
        }
        $output .= Html::endTag('div');
        return $output;
    }
}