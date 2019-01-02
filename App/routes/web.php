<?php

use App\Libraries\Route;

$controllerNameSpace = '\App\Controllers';

Route::get('', [ 'controller' => 'HomeController', 'action' =>'index', 'namespace' => $controllerNameSpace ]);
Route::get('install', [ 'controller' => 'HomeController', 'action' =>'install', 'namespace' => $controllerNameSpace ]);

Route::get('user/login', [ 'controller' => 'UserController', 'action' =>'login', 'namespace' => $controllerNameSpace, 'middleware' => \App\Middlewares\Guest::class ]);
Route::get('user/logout', [ 'controller' => 'UserController', 'action' =>'logout', 'namespace' => $controllerNameSpace, 'middleware' => \App\Middlewares\Member::class ]);

Route::post('user/authenticate', [ 'controller' => 'UserController', 'action' =>'authenticate', 'namespace' => $controllerNameSpace, 'middleware' => \App\Middlewares\Guest::class ]);

Route::get('guestbook/create', [ 'controller' => 'GuestbookController', 'action' =>'create', 'namespace' => $controllerNameSpace, 'middleware' => \App\Middlewares\Member::class ]);
Route::post('guestbook/save', [ 'controller' => 'GuestbookController', 'action' =>'save', 'namespace' => $controllerNameSpace, 'middleware' => \App\Middlewares\Member::class ]);

Route::get('guestbook', [ 'controller' => 'GuestbookController', 'action' =>'index', 'namespace' => $controllerNameSpace ]);
Route::get('guestbook/unpublished', [ 'controller' => 'GuestbookController', 'action' =>'unpublished', 'namespace' => $controllerNameSpace, 'middleware' => \App\Middlewares\Member::class  ]);

//admin actions
Route::get('guestbook/delete', [ 'controller' => 'GuestbookController', 'action' =>'delete', 'namespace' => $controllerNameSpace, 'middleware' => \App\Middlewares\Member::class ]);
Route::get('guestbook/validate', [ 'controller' => 'GuestbookController', 'action' =>'validate', 'namespace' => $controllerNameSpace, 'middleware' => \App\Middlewares\Member::class ]);
Route::get('guestbook/edit', [ 'controller' => 'GuestbookController', 'action' =>'edit', 'namespace' => $controllerNameSpace, 'middleware' => \App\Middlewares\Member::class ]);
Route::post('guestbook/update', [ 'controller' => 'GuestbookController', 'action' =>'update', 'namespace' => $controllerNameSpace, 'middleware' => \App\Middlewares\Member::class ]);

Route::get('404', [ 'controller' => 'HomeController', 'action' =>'notFound', 'namespace' => $controllerNameSpace]);

