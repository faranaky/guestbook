<?php

session_start();
date_default_timezone_set(TIMEZONE);

if (!function_exists('baseUrl')) {
    function baseUrl($atRoot=FALSE, $atCore=FALSE, $parse=FALSE){
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
            $core = $core[0];

            $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
            $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
            $baseUrl = sprintf( $tmplt, $http, $hostname, $end );
        }
        else $baseUrl = 'http://localhost/';

        if ($parse) {
            $baseUrl = parse_url($baseUrl);
            if (isset($baseUrl['path'])) if ($baseUrl['path'] == '/') $baseUrl['path'] = '';
        }

        return $baseUrl;
    }
}

if (!function_exists('url')) {
    function url($path)
    {
        return baseUrl() . $path;
    }
}

if (!function_exists('asset')) {
    function asset($filename)
    {
        return url('/public/assets/' . $filename);
    }
}

if (!function_exists('dd')) {
    function dd($object)
    {
        var_dump($object);
        die;
    }
}

if (!function_exists('redirectHome')) {
    function redirectHome()
    {
        header("Location: " . url(''));
        exit;
    }
}
if (!function_exists('redirect')) {
    function redirect($path)
    {
        header("Location: " . url($path));
        exit;
    }
}
if (!function_exists('redirectBack')) {
    function redirectBack()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
if (!function_exists('setSession')) {
    function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }
}

if (!function_exists('getSession')) {
    function getSession($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
}

if (!function_exists('unsetSession')) {
    function unsetSession($key)
    {
        unset($_SESSION[$key]);
    }
}

if (!function_exists('getTimeAgo')) {

    function getTimeAgo( $date )
    {
        $time = strToTime($date);
        $timeDifference = time() - $time;

        if( $timeDifference < 1 ) { return 'less than 1 second ago'; }
        $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
            30 * 24 * 60 * 60       =>  'month',
            24 * 60 * 60            =>  'day',
            60 * 60                 =>  'hour',
            60                      =>  'minute',
            1                       =>  'second'
        );

        foreach( $condition as $secs => $str )
        {
            $d = $timeDifference / $secs;

            if( $d >= 1 )
            {
                $t = round( $d );
                return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
            }
        }
    }
}
