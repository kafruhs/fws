<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 31.08.2014
 * Time: 22:18
 */

class base_exception_TMS extends BaseException
{
    const TEXTMODULE_NOT_EXISTS = 'base.exception.tms.textModuleNotExists';

    const DUPLICATED_ENTRY      = 'base.exception.tms.duplicatedEntry';

    const NO_MODULE_SELECTED    = 'base.exception.tms.noTextModuleSelected';
}