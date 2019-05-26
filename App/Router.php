<?php


namespace App;

use Config\RoutesPath;

class Router
{
    private $routes;
    public function __construct()
    {
        $this->routes = RoutesPath::getRoutes();
    }
    /**
     * Returns request string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }
    public function run()
    {
        $uri = $this->getURI();
        session_start();
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                //Defining controllers and actions
                $segments = explode('/', $internalRoute);
                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);
                $actionName = 'action' . ucfirst(array_shift($segments));
                $parameters = $segments;
                $controllerName = trim('App\Controllers\ ') . $controllerName;
                //Apply particular controller
                $controllerObject = new $controllerName();
                //Giving array as params to objects' action
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                if ($result !== null) {
                    break;
                }
            }
        }
    }
}