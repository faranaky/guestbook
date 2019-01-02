<?php
namespace App\Libraries\Traits;

use App\Libraries\Database;

trait HasPermission
{
    public function can($permissionName)
    {
        $query = "SELECT * FROM `permissions` INNER JOIN role_permission on id = role_permission.permission_id INNER JOIN users on users.role_id = role_permission.role_id WHERE users.id=:user_id AND name=:permission_name ";
        $params = [
            'user_id' => $this->id,
            "permission_name" => $permissionName
        ];
        $result = Database::query($query, $params);

        return count($result) ? true : false;
    }
}