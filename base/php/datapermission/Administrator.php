<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 10.06.2015
 * Time: 16:08
 */

class base_datapermission_Administrator extends DataPermission
{
    protected function setOccupants(BaseObject $obj)
    {
        $this->groups[] = Group::getGroupLKByName(Group::ADMINISTRATOR);
    }

}