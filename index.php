<?php

require_once( './App/globals.php' );
require_once( './App/configs/app.php' );
require_once( './App/functions.php' );
require_once( './App/configs/database.php' );
require_once( './App/routes/web.php' );

function __autoload($className)
{
    $className = str_replace('\\', '/', $className);
    require_once './' . $className . '.php';
}

$guestBook = new \App\Libraries\Guestbook();
$guestBook->run();