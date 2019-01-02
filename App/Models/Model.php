<?php
namespace App\Models;

use App\Models\Repositories\Repository;

class Model
{
    public $id;

    protected static $repository = Repository::class;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function find($id)
    {
        return static::$repository::find($id);
    }

    /**
     * @return mixed
     */
    public function save()
    {
        return static::$repository::save($this);
    }

    public static function delete($id)
    {
        return static::$repository::delete($id);
    }

}