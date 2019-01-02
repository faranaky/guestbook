<?php
namespace App\Middlewares;

use App\Models\User;

class Guest
{
    protected static $redirectUrl = '/';
    public static function run()
    {
        if(User::isLoggedIn())
        {
            header('Location: ' . '/' );
            exit();
        }
        return true;
    }
}