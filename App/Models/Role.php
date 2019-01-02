<?php
namespace App\Models;

use App\Models\Repositories\Role as Repository;

class Role extends Model
{
    protected $name;

    protected static $repository = Repository::class;

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name();
    }

    /**
     * @param $name
     * @return null
     */
    public static function getByName($name)
    {
        return Repository::getByName($name);
    }

    /**
     * @return mixed
     */
    public function getPermissions()
    {
        return Repository::getPermissions($this->getId());
    }

}