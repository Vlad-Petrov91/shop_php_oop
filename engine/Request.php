<?php

namespace app\engine;

class Request
{
    protected $requstString;
    protected $requestPath;
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

    public function getActivePage()
    {
        preg_match('/[a-z]+/', $this->requstString, $pageString);
        return $pageString[0];
    }

    protected function parseRequest()
    {
        $this->requstString = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $url = explode('/', $this->requstString);
        $this->controllerName = $url[1];
        $this->actionName = $url[2];
        $this->params = $_REQUEST;
        $data = json_decode(file_get_contents('php://input'));
        if (!is_null($data)) {
            foreach ($data as $key => $value) {
                $this->params[$key] = $value;
            }
        }
    }

}