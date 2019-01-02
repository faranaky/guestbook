<?php
namespace App\Controllers;

use App\Helpers\DBInstaller;
use App\Libraries\Database;
use App\Libraries\View;
use App\Models\Role;
use App\Models\User;

class HomeController
{
    public function index()
    {
        if (DBInstaller::isInstalled()) {
            redirect('guestbook');
        }
        redirect('install');
    }

    public function notFound()
    {
        return View::make('errors.404');
    }

    public function install()
    {
        if (DBInstaller::install()) {
            setSession('success', 'Guestbook database is installed successfully');

            // creates an admin
            $role = Role::getByName('admin');
            $admin = new User();
            $admin->setFirstname('Admin')
                ->setLastname('Admin')
                ->setUsername('admin')
                ->setPassword('123456')
                ->setRoleId($role->id)
                ->save();

            // creates a simple user
            $role = Role::getByName('member');
            $member = new User();
            $member->setFirstname('Guest')
                ->setLastname('Guest')
                ->setUsername('guest')
                ->setPassword('123456')
                ->setRoleId($role->id)
                ->save();
        }
        else {
            setSession('warning', 'Guestbook database is already installed');
        }



        redirectHome();
    }
}