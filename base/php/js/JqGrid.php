<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.02.2015
 * Time: 15:00
 */

class base_js_JqGrid 
{
    /**
     * @var string
     */
    protected $elementID = 'searchTable';

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $objClass;

    /**
     * @var array
     */
    protected $getParams = [];

    /**
     * @var array
     */
    protected $colNames = [];

    /**
     * @var base_js_ColModelElement[]
     */
    protected $colModels = [];

    /**
     * @var int
     */
    protected $rowNum;

    /**
     * @var array
     */
    protected $rowList = [10, 25, 50, 100, 250, 500];

    /**
     * class Name of the pager
     *
     * @var string
     */
    protected $pager = '#navGrid';

    /**
     * fieldName of the initial sorted column
     *
     * @var string
     */
    protected $sortname;

    /**
     * initial sorted direction
     *
     * @var string
     */
    protected $sortorder = 'asc';

    /**
     * height of the table
     *
     * @var int
     */
    protected $height =  'auto';

    /**
     * width of the table
     *
     * @var int
     */
    protected $width = 'auto';

    /**
     * show entries
     *
     * @var bool
     */
    protected $viewrecords = 'true';

    /**
     * @var string
     */
    protected $caption = 'Test';

    /**
     * @param string $elementID
     * @return $this
     */
    public function setElementID($elementID)
    {
        $this->elementID = $elementID;
        return $this;
    }

    /**
     * @param string $objClass
     * @return $this
     */
    public function setObjClass($objClass)
    {
        $this->objClass = $objClass;
        return $this;
    }

    /**
     * @param $paramName
     * @param $value
     * @return $this
     */
    public function setGetParam($paramName, $value)
    {
        $this->getParams[$paramName] = $value;
        return $this;
    }

    public function setGetParams(array $paramArray)
    {
        $this->getParams = array_merge($this->getParams, $paramArray);
        return $this;
    }

    /**
     * @param array $colNames
     * @return $this
     */
    public function setColNames($colNames)
    {
        $this->colNames = $colNames;
        return $this;
    }

    /**
     * @param base_js_ColModelElement $colModels
     * @return $this
     */
    public function setColModels(base_js_ColModelElement$colModels)
    {
        $this->colModels[] = $colModels;
        return $this;
    }

    /**
     * @param int $rowNum
     * @return $this
     */
    public function setRowNum($rowNum)
    {
        $this->rowNum = $rowNum;
        return $this;
    }

    /**
     * @param array $rowList
     * @return $this
     */
    public function setRowList($rowList)
    {
        $this->rowList = $rowList;
        return $this;
    }

    /**
     * @param string $pager
     * @return $this
     */
    public function setPager($pager)
    {
        $this->pager = $pager;
        return $this;
    }

    /**
     * @param string $sortname
     * @return $this
     */
    public function setSortname($sortname)
    {
        $this->sortname = $sortname;
        return $this;
    }

    /**
     * @param string $sortorder
     * @return $this
     */
    public function setSortorder($sortorder)
    {
        $this->sortorder = $sortorder;
        return $this;
    }

    /**
     * @param int $height
     * @return $this
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return $this
     */
    public function setViewrecordsFalse()
    {
        $this->viewrecords = 'false';
        return $this;
    }

    /**
     * @param string $caption
     * @return $this
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
        return $this;
    }

    /*
     * create url for jqGrid
     */
    /**
     * @return string
     */
    protected function getFormatedURL()
    {
        $url = HTML_ROOT . '/de/ajax.php?';
        $params = [];
        foreach ($this->getParams as $param => $value) {
            $params[] = $param . '=' . $value;
        }
        $url .= implode('&', $params);
        return $url;
    }

    /**
     * create the col names list
     *
     * @return string
     */
    protected function getFormatedColNames()
    {
        $colNames[] = "'LK'";
        foreach ($this->colNames as $colName) {
            $colNames[] = "'$colName'";
        }
        return "[" . implode(',', $colNames) . "]";
    }

    /**
     * create the col model list
     *
     * @return string
     */
    protected function getFormatedColModel()
    {
        $colModels[] = '{name:"LK",hidden:true}';
        foreach ($this->colModels as $colModel) {
            $colModels[] = "\t\t\t" . $colModel->toString();
        }
        return implode(',' . PHP_EOL, $colModels);
    }


    /**
     * create an script tag for an sortable, searchable, filterable, and so on table
     *
     * @return string
     */
    public function toString()
    {
        $script = '<script language="javascript">' . PHP_EOL;
        $script .= "\t" . '$(function () {$("#searchTable").jqGrid({' . PHP_EOL;
        $script .= "\t\t" . "sortable: true," . PHP_EOL;
        $script .= "\t\t" . "url: '" . $this->getFormatedURL() . "'," . PHP_EOL;
        $script .= "\t\t" . 'contentType: "application/json",' . PHP_EOL;
        $script .= "\t\t" . 'datatype: "json",' . PHP_EOL;
        $script .= "\t\t" . 'loadonce: true,' . PHP_EOL;
        $script .= "\t\t" . "jsonReader: {" . PHP_EOL;
        $script .= "\t\t\t" . "root: 'BaseObjectReader'," . PHP_EOL;
        $script .= "\t\t\t" . "id: 'LK'," . PHP_EOL;
        $script .= "\t\t\t" . "repeatitems: false," . PHP_EOL;
        $script .= "\t\t" . "}," . PHP_EOL;
        $script .= "\t\t" . 'colNames: ' . $this->getFormatedColNames() . ',' . PHP_EOL;
        $script .= "\t\t" . 'colModel: [' .  PHP_EOL;
        $script .= $this->getFormatedColModel() .  PHP_EOL;
        $script .= "\t\t" . '],' .  PHP_EOL;
        $script .= "\t\t" . "rowNum: {$this->rowNum}," . PHP_EOL;
        $script .= "\t\t" . "rowList: [" . implode(',', $this->rowList) . '],' . PHP_EOL;
        $script .= "\t\t" . "pager: '{$this->pager}'," . PHP_EOL;
        $script .= "\t\t" . "sortname: '{$this->sortname}'," . PHP_EOL;
        $script .= "\t\t" . "sortorder: '{$this->sortorder}'," . PHP_EOL;
        $script .= "\t\t" . "height: '{$this->height}'," . PHP_EOL;
        $script .= "\t\t" . "width: '{$this->width}'," . PHP_EOL;
        $script .= "\t\t" . "viewrecords: {$this->viewrecords}," . PHP_EOL;
        $script .= "\t\t" . "caption: '{$this->caption}'," . PHP_EOL;
        $script .= "\t\t" . "rownumbers: true," . PHP_EOL;
        $script .= "\t\t" . "gridview: true," . PHP_EOL;
        $script .= "\t\t" . "altRows: true," . PHP_EOL;
        $script .= "\t\t" . "altclass: 'odd'," . PHP_EOL;
//        $script .= "\t\t" . "multiSort: true," . PHP_EOL;
        $script .= "\t});" . PHP_EOL;
        $script .= "\t" . "$('#searchTable').jqGrid('navGrid', '#navGrid',{edit:false,add:false,del:false});" . PHP_EOL;
        $script .= "\t" . "$('#searchTable').jqGrid('filterToolbar', {stringResult: true, searchOnEnter: false, defaultSearch : 'cn', showQuery: true});" . PHP_EOL;
        $script .= "\t" . "$('#searchTable').jqGrid('inlineNav','#navGrid');" . PHP_EOL;
        $script .= "\t" . "$('#searchTable').jqGrid('navButtonAdd','#navGrid',{caption: 'Spalten', title: 'Reorder Columns', onClickButton : function (){ $('#searchTable').jqGrid('columnChooser'); }});" . PHP_EOL;
        $script .= "\t" . "$('#searchTable').jqGrid('gridResize', { maxWidth: $('#mainContent').width()-$('#mainContent').css('padding').replace('px','') });" . PHP_EOL;
        $script .= "\t});" . PHP_EOL;
        $script .= Html::endTag('script');
        return $script;
    }


}