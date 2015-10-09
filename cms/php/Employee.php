<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.06.2015
 * Time: 10:45
 */

class Employee extends BaseObject
{
    const HEADOFFICE = 'headOffice';

    const CONSULTANT = 'consultant';

    const EMPLOYEE = 'employee';

    protected $table = 'employee';
}