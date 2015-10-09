<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 10.06.2015
 * Time: 16:08
 */

class base_datapermission_FirstEditor extends base_datapermission_Administrator
{
    private $_isNewObject = false;

    protected function setOccupants(BaseObject $obj)
    {
        parent::setOccupants($obj);
        $firstEditor = $obj['firstEditor'];
        if (empty($firstEditor)) {
            $this->_isNewObject = true;
            return;
        }
        if (!$this->isUserOccupant($firstEditor)) {
            $this->users[] = $firstEditor;
        }
    }

    public function isUserOccupant($userLK)
    {
        if ($this->_isNewObject) {
            return true;
        }
        return parent::isUserOccupant($userLK); // TODO: Change the autogenerated stub
    }


}