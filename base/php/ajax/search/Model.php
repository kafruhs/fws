<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 21.01.2015
 * Time: 08:23
 */

class base_ajax_search_Model extends base_ajax_Model
{

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
        $requestHelper = $this->controller->getRequestHelper();
        $class = $requestHelper->getParam('class');
        $object = Factory::createObject($class);
        /** @var BaseObject[] $result */
        $result = Finder::create($class)->find();
        $urlColumns = $requestHelper->getParam('cols');

        if (!is_null($urlColumns)) {
            if ($urlColumns == 'all') {
                $fi = new Fieldinfo($class);
                $columnNames = $fi->getAllFieldNames();
            } else {
                $columnNames = explode(',', $urlColumns);
            }
        } else {
            $columnNames = $object->getStdSearchColumns();
        }

        $response = new stdClass();


        $i = 0;
        foreach ($result as $obj) {
            $values = [];
            $values['LK'] = (int) $obj['LK'];
            foreach ($columnNames as $colName) {
                $values[$colName] = $obj->getField($colName);
            }

            $response->BaseObjectReader[] = $values;
            $i++;
        }
        $jsonObject = json_encode($response);
        echo $jsonObject;
        exit();
    }
}