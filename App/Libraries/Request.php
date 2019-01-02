<?php

namespace App\Libraries;

class Request {

    public static function post($data)
    {
        if (isset($_POST[$data]))
            return strip_tags(urldecode($_POST[$data]));
        return '';
    }

    public static function get($data)
    {
        if (isset($_GET[$data]))
            return strip_tags(urldecode($_GET[$data]));
        return '';
    }

    public static function file($data)
    {
        if (isset($_FILES[$data]))
            return $_FILES[$data];
        return '';
    }
}
