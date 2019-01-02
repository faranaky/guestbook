<?php
namespace App\Models\Repositories;

use App\Libraries\Database;

class Role extends Repository
{
    public static $table = 'roles';

    protected static $modelClass = \App\Models\Role::class;

    /**
     * @param $id
     * @return null
     */
    public static function getByName($name)
    {
        $query = "SELECT * FROM `" . self::$table . "` WHERE name = :name";
        $params =[
            ':name'    => $name
        ];

        $result = Database::query($query, $params, static::$modelClass);

        return self::first($result);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getPermissions($id)
    {
        $permissionTable = Permission::class;

        $permissionTable = $permissionTable::$table;

        $rolePermissionTable = 'role_permission';

        $query = "SELECT * FROM `" . $permissionTable . "` INNER JOIN `" .
            $rolePermissionTable . "` ON id = " . $rolePermissionTable . ".permission_id
            WHERE " . $rolePermissionTable . ".role_id = :role_id";

        $params = ['role_id' => $id];

        $result = Database::query($query, $params, static::$modelClass);
        return $result;
    }
}