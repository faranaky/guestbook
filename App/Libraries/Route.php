<?php

namespace App\Libraries;

class Route {

    /**
     * @return int
     */
    public static function isRouteValid()
    {
        global $Routes;
        $uri = $_SERVER['REQUEST_URI'];

        if (!in_array(explode('?',$uri)[0], $Routes))
        {
            return false;
        }
        return true;
    }

    /**
     * @param $route
     */
    private static function registerRoute($route)
    {
        global $Routes;
        $Routes[] = BASEDIR . $route;
    }

    /**
     * @param $dynamicRoutes
     * @return mixed
     */
    public static function dynamic($dynamicRoutes)
    {
        $routeComponents = explode('/', $dynamicRoutes);

        $uriComponents = explode('/', substr($_SERVER['REQUEST_URI'], strlen(BASEDIR) - 1));

        for ($i = 0; $i < count($routeComponents); $i++)
        {
            if ($i + 1 <= count($uriComponents) - 1)
            {
                $routeComponents[$i] = str_replace("<$i>", $uriComponents[ $i + 1 ], $uriComponents[ $i ]);
            }
        }
        $route = implode($routeComponents, '/');

        return $route;
    }

    public static function get($route, $params)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            static::set($route, $params);
        }
    }

    public static function post($route, $params)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            static::set($route, $params);
        }
    }

    /**
     * @param $route
     * @param $closure
     */
    public static function set($route, $params)
    {
        $controllerName = isset($params['controller']) ? $params['controller']: '';
        $namespace      = isset($params['namespace']) ? $params['namespace']: '';
        $action         = isset($params['action']) ? $params['action']: '';
        $middlesware    = isset($params['middleware']) ? $params['middleware']: '';

        $controllerName = $namespace . '\\' . $controllerName;


        $controller = new $controllerName();

        if ($_SERVER['REQUEST_URI'] == BASEDIR . $route)
        {
            if($middlesware)
                $middlesware::run();
            self::registerRoute($route);
            $controller->$action();
        }
        else if (explode('?', $_SERVER['REQUEST_URI'])[0] == BASEDIR . $route)
        {
            if($middlesware)
                $middlesware::run();
            self::registerRoute($route);
            $controller->$action();
        }
    }

    public static function includeController($controllerName)
    {
        if (Route::isRouteValid())
        {
            // Create the view and the view controller.
            require_once( './app/controllers/' . $controllerName . '.php' );
            return true;
        }
    }
}
