<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 05.02.2015
 * Time: 10:53
 */

class base_exception_Validation extends BaseException
{
    const MANDATORY_FIELD_EMPTY = 'base.exception.validation.mandatoryFieldEmpty';

    const WRONG_DATETIME_FORMAT = 'base.exception.validation.wrongDateTimeFormat';

    const WRONG_DATE_FORMAT = 'base.exception.validation.wrongDateFormat';

    const WRONG_FLOAT_FORMAT = 'base.exception.validation.wrongFloatFormat';

    const WRONG_PERCENT_VALUE = 'base.exception.validaion.wrongPercentValue';

    const MISSING_PARAM = 'base.exception.validation.missingParam';
}