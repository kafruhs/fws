<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.10.2014
 * Time: 11:57
 */

class Flat
{
    /**
     * get the actual logged in User
     *
     * @return User|null
     */
    public static function user()
    {
        if (isset($GLOBALS['argv'])) {
            if (isset($GLOBALS['user'])) {
                return $GLOBALS['user'];
            }
            $GLOBALS['user'] = new User();
            $GLOBALS['user']->load(1);
            return $GLOBALS['user'];
        }

        if (!User::isLoggedIn()) {
            return Factory::createObject('User');
        }

        $user = $_SESSION['user'];

        if (! $user instanceof User) {
            return Factory::createObject('user');
        }
        return $user;
    }

    public static function language()
    {
        if (isset($GLOBALS['language'])) {
            return $GLOBALS['language'];
        }

        return 'de';
    }

    public static function getClassConstants($class)
    {
        $reflect = new ReflectionClass($class);
        return array_values($reflect->getConstants());
    }
} 