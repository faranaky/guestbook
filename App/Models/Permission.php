<?php
namespace App\Models;

use App\Models\Repositories\Permission as Repository;

class Permission extends Model
{
    protected $name;

    protected static $repository = Repository::class;

    public function getName()
    {
        return $this->getName();
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}