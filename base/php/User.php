<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.08.2014
 * Time: 07:53
 */

class User extends BaseObject
{
    const LOGIN_SUCCESS = 1;

    const LOGIN_FAILURE = 2;

    const LOGIN_USER_DISABLED = 3;

    const LOGIN_MAX_TRIES = 5;

    const LOGOUT_SUCCESS = 1;

    const LOGOUT_FAILURE = 2;

    const USER_DISABLED = 'Y';

    const USER_NOT_DISABLED = 'N';

    protected $table = 'user';

    protected $stdSearchColumns = array('userid', 'firstName', 'lastName', 'email', 'homepage', 'lastLogin');

    protected $useCache = true;

    protected $mnFields = array('groups');

    /**
     * login of an user with the given userid and password
     *
     * @param string $userid
     * @param string $password
     *
     * @return int
     * @throws base_database_Exception
     */
    public static function login($userid, $password)
    {
        $table = DB::table(Factory::createObject('user')->getTable());
        $where = DB::where($table->getColumn('userid'), DB::stringTerm($userid));
        $res = Finder::create('user')->setWhere($where)->find();

        if (empty($res)) {
            return self::LOGIN_FAILURE;
        }
        $user = current($res);
        if ($user['disabled'] == self::USER_DISABLED) {
            return self::LOGIN_USER_DISABLED;
        }
        if ($user['password'] != md5($password)) {
            return self::_updateLoginTries($table, $user);
        }

        try {
            $time = new base_date_model_DateTime();
            $updateData = array(
                'ip' => DB::stringTerm($_SERVER['REMOTE_ADDR']),
                'sessionid' => DB::stringTerm(session_id()),
                'lastLogin' => DB::stringTerm($time->toDB()),
                'loginTries' => DB::intTerm(0),
            );
            self::_updateUserLoginData($table, $where, $updateData);
        } catch (Exception $e) {
            return self::LOGIN_FAILURE;
        }
        $user['ip'] = $_SERVER['REMOTE_ADDR'];
        $user['sessionid'] = session_id();
        $user['lastLogin'] = $time;
        $user['loginTries'] = 0;
        $_SESSION['user'] = $user;

        return self::LOGIN_SUCCESS;
    }

    /**
     * is a user loggedin and the correct session stored?
     *
     * @return bool
     */
    public static function isLoggedIn()
    {
        if (!isset($_SESSION['user'])) {
            return false;
        }

        if (!$_SESSION['user'] instanceof User) {
            return false;
        }

        $user = $_SESSION['user'];

        if ($user['sessionid'] != session_id()) {
            return false;
        }

        if ($user['ip'] != $_SERVER['REMOTE_ADDR']) {
            return false;
        }

        return true;
    }

    public static function logout()
    {
        if (!self::isLoggedIn()) {
            return self::LOGOUT_SUCCESS;
        }

        $table = DB::table('user');
        $where = DB::where($table->getColumn('LK'), DB::intTerm(Flat::user()->getLogicalKey()));
        $updateData = array(
            'ip' => DB::stringTerm(''),
            'sessionid' => DB::stringTerm(''),
        );
        try {
            self::_updateUserLoginData($table, $where, $updateData);
            session_destroy();
            return self::LOGOUT_SUCCESS;
        } catch (Exception $e) {
            return self::LOGOUT_FAILURE;
        }
    }

    /**
     * update the user login data like ip, sessionid and last login timestamp
     *
     * @param base_database_Table $table
     * @param base_database_Where $where
     * @param array               $fieldsWithValues
     * @throws base_database_Exception
     */
    private static function _updateUserLoginData(base_database_Table $table, base_database_Where $where, array $fieldsWithValues)
    {
        $updateStatement = new base_database_statement_Update();
        $updateStatement->setTable($table);

        foreach ($fieldsWithValues as $field => $value) {
            $updateStatement->setColumnValue($table->getColumn($field), $value);
        }
        $updateStatement->setWhere($where);

        DB::beginTransaction();
        $updateStatement->insertDatabase();
        DB::endTransaction();
    }

    private static function _updateLoginTries(base_database_Table $table, User $user)
    {
        $loginTries = $user['loginTries'];
        $where = DB::where($table->getColumn('userid'), DB::term($user['userid']));
        if ($loginTries < self::LOGIN_MAX_TRIES) {
            $loginTries++;
            self::_updateUserLoginData($table, $where, array('loginTries' => DB::term($loginTries)));
            return self::LOGIN_FAILURE;
        }
        if ($loginTries >= self::LOGIN_MAX_TRIES) {
            self::_updateUserLoginData($table, $where, array('disabled' => DB::term(self::USER_DISABLED)));
            return self::LOGIN_USER_DISABLED;
        }
        return self::LOGIN_FAILURE;

    }

    public function getDisplayName()
    {
        return 'Benutzer';
    }

    public function isEntitled($right)
    {
        if (is_int($right)) {
            $permission = $right;
        } else {
            $permission = Permission::getPermissionLKByName($right);
        }
        /** geht besser */
        if ($permission == Permission::getPermissionLKByName(Permission::EVERYBODY)) {
            return true;
        }

        if ($this->isNewObject()) {
            return false;
        }

        $connGroupRight = new ConnGroupRight();
        $connGroupRights = $connGroupRight->find($permission, ConnGroupRight::CLASS_RIGHT);
        $isEntitled = false;
        foreach ($connGroupRights as $connGroupRight) {
            $groupLK = $connGroupRight->getLkLeft();
            if ($this->isGroupMember($groupLK)) {
                $isEntitled = true;
            }
        }
        return $isEntitled;
    }

    public function isGroupMember($groupLK)
    {
        /** @var ConnUserGroup $connUserGroup */
        foreach ($this['groups'] as $connUserGroup) {
            if ($connUserGroup->getLkRight() == $groupLK) {
                return true;
            }
        }
        return false;
    }
} 