<?php
namespace App\Controllers;
use App\Models\User;
use App\Libraries\View;
use App\Libraries\Request;

class UserController
{
    public function login()
    {

        //var_dump(User::create('faranaky', 'hello', 'faranak', 'yazdanar'));
        /*$user = new User();
        $user->setFirstname('fara');
        $user->setUsername('myusername');
        $user->setPassword('1234');
        $user->setLastname('yazdanfar');
        $user->save();*/

        return View::make('users.login');
    }

    public function authenticate()
    {
        $username = Request::post('username');
        $password = Request::post('password');

        $errors = [];

        if(empty($username))
            $errors[] = "Username field is required";
        if(empty($password))
            $errors[] = "Password field is required";

        if(count($errors)) {
            setSession('errors', $errors);
            redirectBack();
        }

        $user = User::login($username, $password);

        if(!$user) {
            setSession('warning', 'Invalid username or password');
            redirectBack();
        }

        redirectHome();
    }

    public function logout()
    {
        User::logout();
        redirectBack();
    }
}