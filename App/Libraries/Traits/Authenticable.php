<?php
namespace App\Libraries\Traits;

use App\Models\User;

trait Authenticable
{
    /**
     * @param $username
     * @param $password
     * @return bool|null
     */
    public static function login($username, $password)
    {
        $user = User::getUserByUsernameAndPassword($username, $password);

        if( !empty($user))
        {
            $user->setToken()->save();
            $token = $user->getToken();
            self::setUserTokenCookie($token);
            return $user;
        }
        return false;
    }

    /**
     * @return bool|null
     */
    public static function isLoggedIn()
    {
        if (isset($_COOKIE['SSID']))
        {
            $user = getSession('user');
            $token = $_COOKIE['SSID'];
            if ($user) {
                //while user is browsing expiration time will be updated
                if(!headers_sent())
                    self::setUserTokenCookie($token);
                return $user;
            }
            $token = $_COOKIE['SSID'];
            $user = static::getUserByToken($token);
            if(!empty($user)) {
                //while user is browsing expiration time will be updated
                self::setUserTokenCookie($token);
                setSession('user', $user);
                return $user;
            }
        }
        unsetSession('user');
        return false;
    }

    public static function logout()
    {
        unsetSession('user');
        setcookie("SSID", '', time(), BASEDIR);
    }

    /**
     * @param $token
     */
    public static function setUserTokenCookie($token)
    {
        setcookie("SSID", $token, time() + 3600, BASEDIR);
    }
}