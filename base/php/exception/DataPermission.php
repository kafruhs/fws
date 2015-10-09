<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 10.06.2015
 * Time: 15:57
 */

class base_exception_DataPermission extends BaseException
{
    const SET_OCCUPANTS_NOT_SET = 'base.exception.dataPermission.setOccupantsNotSet';

    const FACTORY_NO_INSTANCE_OF_DP = 'base.exception.dataPermission.facotyNoInstanceOfDP';
}