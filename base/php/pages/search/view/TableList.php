<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 15.06.2015
 * Time: 07:38
 */

class base_pages_search_view_TableList extends View
{
    /**
     * @var array   columns to be shown in the tableList
     */
    protected $showColumns;

    /**
     * @var array   objects to be displayed
     */
    protected $data;

    /**
     * @var base_pages_search_controller_TableList
     */
    protected $controller;

    /**
     * manages all page subelements and is defined in the different views
     *
     * @param OutputDevice $od
     */
    public function display(OutputDevice $od)
    {
        $this->data = $this->controller->getModelData();
        $this->showColumns = $this->controller->getColLabelNamesConnection();
        $od->addContent($this->_setFilterOptions());
        $table = new base_html_model_Table();
        $table->setCssClass('search');
        $this->_setTableHead($table);
        foreach ($this->data as $obj) {
            $this->_setTableRow($table, $obj);
        }
        $od->addContent($table->toString());
    }

    private function _setTableHead(base_html_model_Table $table)
    {
        $row = new base_html_model_table_Row();
        $row->setRowType(base_html_model_table_Row::ROWTAG_HEAD);
        foreach ($this->showColumns as $colName => $colLabel) {
            $cell = new base_html_model_table_Cell();
            $cell->setCssClass($colName);
            $cell->setContent($colLabel);
            $row->addCell($cell);
        }
        $cell = new base_html_model_table_Cell();
        $cell->setCssClass('task');
        $row->addCell($cell);
        $table->addHeadRow($row);
    }

    private function _setTableRow(base_html_model_Table $table, BaseObject $obj)
    {
//        $user = Flat::user();
//        if (!$user->isEntitled($obj->getPermissionForViewMode(DisplayClass::VIEW))) {
//            return;
//        }
        $row = new base_html_model_table_Row();
        $row->setId(strtolower(get_class($obj)) . '_' . $obj->getLogicalKey());
        foreach ($this->showColumns as $colName => $colLabel) {
            $cell = new base_html_model_table_Cell();
            $cell->setCssClass($colName);
            $cell->setContent($obj->getField($colName));
            $row->addCell($cell);
        }

        $objClass = get_class($obj);
        $taskLinks  = Html::url($_SERVER['SCRIPT_NAME'] . '?controller=base_pages_input_controller_BaseObject&class=' . $objClass . '&LK=' . $obj->getLogicalKey() . '&mode=view', Html::pictogram('view'), ['title' => 'Anzeigen']);
        $taskLinks .= Html::url($_SERVER['SCRIPT_NAME'] . '?controller=base_pages_input_controller_BaseObject&class=' . $objClass . '&LK=' . $obj->getLogicalKey() . '&mode=edit', Html::pictogram('edit'), ['title' => 'Bearbeiten']);
        $taskLinks .= Html::url(HTML_ROOT . '/de/ajax.php?controller=base_ajax_delete_Controller&class=' . $objClass . '&LK=' . $obj->getLogicalKey(), Html::pictogram('delete'), ['class' => 'ajaxOnClick', 'title' => 'Löschen']);
        $cell = new base_html_model_table_Cell();
        $cell->setCssClass('task');
        $cell->setContent($taskLinks);
        $row->addCell($cell);

        $table->addRow($row);
    }

    private function _setFilterOptions()
    {
        $form = new base_html_model_Form();
        $output = $form->start('#', 'post', array('id' => 'tableOperations'));

        $output .= Html::startTag('div', array('class' => 'tableOperations'));
        $output .= Html::startTag('div', array('id' => 'sort'));
        $output .= 'Sortieren nach: ';
        $output .= "<select name='sort' onChange='this.form.submit()'>";
        foreach ($this->showColumns as $colName => $colLabel) {
            if ($colName == $this->controller->getFilterParam('sort')) {
                $output .= "<option value='$colName' selected>$colLabel</option>";
            } else {
                $output .= "<option value='$colName'>$colLabel</option>";
            }
        }
        $output .= '</select>';
        $output .= "<select name='direction' onChange='$(\"#tableOperations\").submit()'>";
        $output .= "<option value='" . base_database_Order::ASC . "'>aufsteigend</option>";
        $output .= "<option value='" . base_database_Order::DESC ."'";
        if ($this->controller->getFilterParam('direction') == base_database_Order::DESC) {
            $output .= ' selected';
        }
        $output .= ">absteigend</option>";
        $output .= "</select>";

        $output .= Html::endTag('div');

        $output .= Html::startTag('div', array('class' => 'numberOfData'));
        $output .= 'Einträge ';
        $output .= "<select name='limit' onChange='this.form.submit()'>";
        $limit = $this->controller->getFilterParam('limit');
        foreach (array(10, 25, 50, 100) as $number) {
            if ($number == $limit) {
                $output .= "<option value=$number selected='selected'>$number</option>";
            } else {
                $output .= "<option value=$number>$number</option>";
            }
        }
        $output .= "</select> ";
        $numPages = ceil($this->controller->countData() / $limit);
        $output .= "Seite: " . Html::singleTag('input', array('name' => 'page', 'id' => 'pager', 'size' => 1, 'value' => $this->controller->getFilterParam('page'))) . " / "
            . Html::startTag('span', array('id' => 'numPages')) . $numPages . Html::endTag('span');
        $output .= Html::endTag('div');
        $output .= Html::endTag('div');

        return $output;
    }
}