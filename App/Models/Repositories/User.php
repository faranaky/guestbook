<?php
namespace App\Models\Repositories;

use App\Libraries\Database;

class User extends Repository
{
    public static $table = 'users';

    public static $fillables = ['username', 'password', 'firstname', 'lastname', 'role_id', 'token', 'created_at'];

    protected static $modelClass = \App\Models\User::class;


    /**
     * @param $username
     * @param $password
     * @param $firstname
     * @param $lastname
     * @return mixed
     */
    public static function create($username, $password, $firstname, $lastname)
    {
        $query = "INSERT INTO `" . self::$table . "` (`username`, `password`, `firstname`, `lastname`, `created_at`) VALUES ('$username', '$password', '$firstname', '$lastname', NOW())";
        $result = Database::query($query, [],\App\Models\User::class);

        return $result;
    }

    /**
     * @param $username
     * @param $password
     * @return null
     */
    public static function getUserByUsernameAndPassword($username, $password)
    {
        $params = [':username' => $username, ':password' => \App\Models\User::encryptPassword($password)];
        $query = "SELECT * FROM `" . self::$table . "` WHERE username=:username AND password=:password";

        $result = Database::query($query, $params, \App\Models\User::class);

        return self::first($result);
     }

    /**
     * @param $token
     * @return null
     */
    public static function getUserByToken($token)
    {
        $params = ['token' => $token];
        $query = "SELECT id, firstname, lastname, username, role_id FROM `" . self::$table . "` WHERE token = :token";
        $result = Database::query($query, $params, \App\Models\User::class);

        return self::first($result);
    }

}