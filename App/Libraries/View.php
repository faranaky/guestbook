<?php

namespace App\Libraries;

class View {
    /**
     * @param $view
     * @param array $data
     */
    public static function make($view, $data = [])
    {
        extract($data);
        $view = str_replace('.', '/', $view);
        require_once( './App/views/' . $view . '.php' );
    }
}