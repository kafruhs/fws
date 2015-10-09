<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 15.06.2015
 * Time: 07:18
 */

class base_pages_search_Model extends Model
{
    /**
     * @var string  class, the search is made for
     */
    protected $class;

    /**
     * @var base_database_Order  order condition of the search
     */
    protected $sort = 'LK';

    /**
     * @var string  declares the order direction
     */
    protected $direction = base_database_Order::ASC;

    /**
     * @var base_database_Limit  limit codition of the search
     */
    protected $limit;

    /**
     * @var array   filter params for view
     */
    protected $params;

    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * set data
     *
     * @return mixed
     */
    public function setData()
    {
        $this->_setRelevantParams();
        $dataPermission = DataPermission::createObject(Factory::createObject($this->class));
        $dataPermission->getOccupants();
        $finder = Finder::create($this->class);
        if ($this->sort instanceof base_database_Order) {
            $finder->setOrder($this->sort);
        }
        if ($this->limit instanceof base_database_Limit) {
            $finder->setlimit($this->limit);
        }
        $this->data = $finder->find();

    }

    /**
     * set all relevant params for the search
     */
    private function _setRelevantParams()
    {
        $rh = $this->controller->getRequestHelper();
        $this->class = $rh->getParam('class');
        $sort = $rh->getParam('sort');
        if (is_null($sort)) {
            $sort = 'LK';
        }
        $this->params['sort']  = $sort;
        $direction = $rh->getParam('direction');
        if (is_null($direction)) {
            $direction = base_database_Order::ASC;
        }
        $this->params['direction'] = $direction;
        $this->_setSort();
        $limit = $rh->getParam('limit');
        if (is_null($limit)) {
            $limit = 25;
        }
        $this->params['limit'] = $limit;
        $page = $rh->getParam('page');
        if (is_null($page)) {
            $page = 1;
        }
        $this->params['page'] = $page;
        $this->_setLimit();
    }

    public function getColLabelNamesConnection()
    {
        $obj = Factory::createObject($this->class);
        $colLabelsByName = [];
        $showCols = $this->controller->getRequestHelper()->getParam('showCols');
        if (empty($showCols)) {
            $showCols = $obj->getStdSearchColumns();
        } else {
            $showCols = explode(',', $showCols);
        }
        foreach ($showCols as $colName) {
            $colLabelsByName[$colName] = $obj->getFieldinfo($colName)->getFieldLabel();
        }
        return $colLabelsByName;
    }

    public function countData()
    {
        return Finder::create($this->class)->count();
    }

    private function _setSort()
    {
        $obj = Factory::createObject($this->class);
        $table = DB::table($obj->getTable());
        $order = new base_database_Order($table->getColumn($this->params['sort']), $this->params['direction']);
        $this->sort = $order;
    }

    private function _setLimit()
    {
        $limitValue = (int) $this->params['limit'];
        $page = (int) $this->params['page'];
        $offset = $limitValue * ($page - 1);
        $limit = new base_database_Limit($limitValue);
        $limit->setOffset($offset);
        $this->limit = $limit;
    }
}