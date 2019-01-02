<?php

namespace App\Libraries;

class Guestbook
{

    public function getRoute()
    {
        global $Routes;
        $uri = $_SERVER['REQUEST_URI'];

        if (!in_array(explode('?',$uri)[0], $Routes))
        {
            redirect('404');
        }

        return $uri;
    }

    public function run()
    {
        $this->getRoute();
    }
}
