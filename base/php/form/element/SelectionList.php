<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 15.01.2015
 * Time: 07:46
 */

class base_form_element_SelectionList extends base_form_Input
{
    protected $class = 'selectionList';

    /**
     * show the data without input element, because editing is not possible
     *
     * @return string
     */
    protected function getReadOnlyDisplay()
    {
        $table = DB::table('selectionListEntry');
        $where = DB::where($table->getColumn('PK'), DB::intTerm($this->value));
        $select = new base_database_statement_Select();
        $select->setTable($table);
        $select->setWhere($where);
        $select->setColumns([$table->getColumn('name')]);
        $res = $select->fetchDatabase();
        if (empty($res)) {
            return 'keine Angabe';
        }

        return $res[0]['name'];
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