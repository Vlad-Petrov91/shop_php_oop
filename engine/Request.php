<?php

namespace app\engine;

class Request
{
    protected $requstString;
    protected $controllerName;
    protected $actionName;
    protected $method;
    protected $params = [];


    public function __construct()
    {
        $this->parseRequest();
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
    public function getControllerName()
    {
        return $this->controllerName;
    }

    public function getActionName()
    {
        return $this->actionName;
    }

    protected function parseRequest()
    {
        $this->requstString = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $url = explode('/', $this->requstString);
        $this->controllerName = $url[1];
        $this->actionName = $url[2];
        $this->params = $_REQUEST;
    }

}