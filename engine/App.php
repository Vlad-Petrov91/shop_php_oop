<?php

namespace app\engine;

use app\models\repositories\BasketRepository;
use app\models\repositories\ProductRepository;
use app\models\repositories\UserRepository;
use app\traits\TSingletone;
use app\engine\Router;

class App
{
    use TSingletone;

    public $config;
    private $components;
    private $controller;
    private $action;

    public function run($config)
    {
        $this->config = $config;
        $this->components = new Storage();
        // вызов контроллера(старая версия)
        $this->runController();

        // переход на router


    }

    protected function runController()
    {
        $router = $this->router->run();
//        $this->controller = $this->request->getControllerName() ?: 'index';
//        $this->action = $this->request->getActionName();
//        $controllerClass = $this->config['controllers_namespaces'] . ucfirst($this->controller) . "Controller";
//        if (class_exists($controllerClass)) {
//            $controller = new $controllerClass(new TwigRender());
//            $controller->runAction($this->action);
//        } else {
//            echo '404';
//        }
    }

    public function createComponent($name)
    {
        if (isset($this->config['components'][$name])) {
            $params = $this->config['components'][$name];
            $class = $params['class'];
            if (class_exists($class)) {
                unset($params['class']);

                $reflection = new \ReflectionClass($class);
                return $reflection->newInstanceArgs($params);
            } else {
                die("Нет класса компонента");
            }
        } else {
            die("Нет класса компонента");
        }
    }

    /**
     * @return static
     */
    public static function call()
    {
        return static::getInstance();
    }

    public
    function __get($name)
    {
        return $this->components->get($name);
    }

}