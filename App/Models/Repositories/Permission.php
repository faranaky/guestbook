<?php
namespace App\Models\Repositories;

use App\Libraries\Database;

class Permission extends Repository
{
    public static $table = 'permissions';

    public static $fillables = ['name'];



}