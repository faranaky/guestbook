<?php
namespace App\Middlewares;

use App\Models\User;

class Member
{
    protected static $redirectUrl = '/';
    public static function run()
    {
        if(!User::isLoggedIn())
        {
            header('Location: ' . '/user/login' );
            exit();
        }
        return true;
    }
}