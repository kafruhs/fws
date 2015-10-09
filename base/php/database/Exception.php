<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.08.2014
 * Time: 08:22
 */

class base_database_Exception extends BaseException
{
    const NO_INT_VALUE                    = 'base.exception.database.noIntValue';

    const NO_STRING_VALUE                    = 'base.exception.database.noStringValue';

    const DB_CONNECTION_NOT_POSSIBLE      = 'base.exception.database.cantConnectToDB';

    const DB_TRANSACTION_ALREADY_STARTED  = 'base.exception.database.transactionAlreadyStarted';

    const DB_TRANSACTION_NOT_ACTIVE       = 'base.exception.database.transactionNotActive';

    const DB_COMMIT_ABORTED_DUE_TO_ERRORS = 'base.exception.database.commitAbortedDueToErrors';

    const DB_COMMIT_FAILED                = 'base.exception.database.commitFailed';

    const DB_EXEC_FAILED                  = 'base.exception.database.execFailed';

    const DB_QUERY_FAILED                 = 'base.exception.database.queryFailed';

    const DB_DBNAME_MISSED                = 'base.exception.database.dbNameMissed';

    const NO_VALID_COLTYPE                = 'base.exception.database.noValidColType';

    const NO_COLS_ADDED                   = 'base.exception.database.noColsAdded';

    const TABLE_COLUMN_NOT_EXISTS         = 'base.exception.database.columnNotExists';

    const NO_VALID_OPERATOR               = 'base.exception.database.noValidOperator';

    const NO_VALID_ORDER_DIRECTION        = 'base.exception.database.noValidOrderDirection';

    const NO_WHERE_GIVEN                  = 'base.exception.database.noWhereGiven';
}