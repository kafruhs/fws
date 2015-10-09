<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 24.03.2015
 * Time: 09:25
 */

class medexchange_ajax_autocomplete_pzn_Model extends base_ajax_Model
{
    const CMD_GETPZNS = true;

    /**
     * @return bool
     */
    protected function isExecuteable()
    {
        return true;
    }

    /**
     * execute the actual ajax request
     */
    protected function executeRequest()
    {
        if (is_null($this->controller->getRequestHelper()->getParam('cmd'))) {
            $values = $this->getPZNs();
        } else {
            $values = $this->getData();
        }
        $jsonObject = json_encode($values);
        echo $jsonObject;
        exit();
    }

    /**
     * @return array
     * @throws base_database_Exception
     */
    protected function getPZNs()
    {
        $requestHelper = $this->controller->getRequestHelper();
        $pzn = $requestHelper->getParam('term');
        $obj = Factory::createObject('medicament');
        $table = DB::table($obj->getTable());
        $where = DB::where($table->getColumn('pzn'), DB::term("%$pzn%"), base_database_Where::LIKE);
        $finder = Finder::create('medicament')->setWhere($where);
        $result = $finder->find(array($table->getColumn('pzn')));
        $values = [];
        foreach ($result as $row) {
            $values[] = ['label' => $row['pzn'], 'value' => $row['pzn']];
        }
        return $values;
    }

    protected function getData()
    {
        $requestHelper = $this->controller->getRequestHelper();
        $pzn = $requestHelper->getParam('pzn');
        $obj = Factory::createObject('medicament');
        $table = DB::table($obj->getTable());
        $where = DB::where($table->getColumn('pzn'), DB::term($pzn));
        $finder = Finder::create('medicament')->setWhere($where);
        $result = $finder->find();
        if (empty($result)) {
            return array();
        }
        /** @var BaseObject $obj */
        $obj = $result[0];
        foreach ($obj->getAllFields() as $fi) {
            if ($fi->getDisplayClass() == 'system') {
                continue;
            }
            $values[$fi->getFieldName()] = $obj->getField($fi->getFieldName());
        }
        return $values;
    }
}