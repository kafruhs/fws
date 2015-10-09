<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 10.06.2015
 * Time: 16:08
 */

class base_datapermission_Nobody extends DataPermission
{
    protected function setOccupants(BaseObject $obj)
    {
    }

    public function isUserOccupant($userLK)
    {
        return false;
    }


}