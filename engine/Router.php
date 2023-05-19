<?php

namespace app\engine;

use app\controllers\IndexController;
use app\engine\App;
use app\engine\TwigRender;


class Router
{

    public array $routes;


    public function __construct()
    {
        $this->routes = include __DIR__ . "/../config/routes.php";
    }

    public function run()
    {
        $requestString = App::call()->request->requstString;
        $requestString = parse_url($requestString)['path'];
        $requestParams = App::call()->request->params;
//        die(var_dump($requestString, $requestParams));
        foreach ($this->routes as $uri => $controllerAndAction) {
            if ($uri === $requestString) {
                $controllerClass = App::call()->config['controllers_namespaces'] . $controllerAndAction['controller'] . 'Controller';
                if (class_exists($controllerClass)) {
                   $controller = new $controllerClass(new TwigRender());
                   $method = 'action' . $controllerAndAction['action'];
//                    $controller->runAction($controllerAndAction['action'],$requestParams);
                    $callback = [$controller, $method];

                    call_user_func_array($callback, [$requestParams]);
                } else {
                    echo '404';
                }
            }

        }

    }
}