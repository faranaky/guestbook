<?php
namespace App\Models;

use App\Helpers\General;
use App\Libraries\Traits\Authenticable;
use App\Models\Repositories\User as Repository;
use App\Libraries\Traits\HasPermission;

class User extends Model
{
    use HasPermission;
    use Authenticable;

    public $username;
    public $password;
    public $firstname;
    public $lastname;
    public $token;
    public $role_id;

    protected static $repository = Repository::class;
    /**
     * @param $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @param $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = self::encryptPassword($password);
        return $this;
    }

    /**
     * @param $firstname
     * @return $this
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @param $lastname
     * @return $this
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    public function setRoleId($roleId)
    {
        $this->role_id = $roleId;
        return $this;
    }

    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * @param $username
     * @param $password
     * @param $firstname
     * @param $lastname
     */
    public static function create($username, $password, $firstname, $lastname)
    {
        $password = self::encryptPassword($password);
        Repository::create($username, $password, $firstname, $lastname);
    }

    /**
     * @return $this
     */
    public function setToken()
    {
        $this->token = General::generateRandom();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param $password
     * @return mixed
     */
    public static function encryptPassword($password)
    {
        return md5($password);
    }

    public function getRole()
    {
        return Role::getRoleById($this->getRoleId());
    }

    public static function getUserByToken($token)
    {
        return Repository::getUserByToken($token);
    }

    public static function getUserByUsernameAndPassword($username, $password)
    {
        return Repository::getUserByUsernameAndPassword($username, $password);
    }

}