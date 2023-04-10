<?php

session_start();

use app\engine\Autoload;
use app\engine\Db;
use app\models\{User, Product};
use app\engine\{Render, TwigRender};
use app\engine\Request;

include __DIR__ . "/../engine/Autoload.php";
include __DIR__ . "/../config/config.php";

spl_autoload_register([new Autoload(), 'loadClass']);
require_once '../vendor/autoload.php';

$request = new Request();

$controllerName = $request->getControllerName() ?: 'index';
$actionName = $request->getActionName();


$controllerClass = CONTROLLER_NAMESPACE . ucfirst($controllerName) . "Controller";

if (class_exists($controllerClass)) {
    $controllerClass = new $controllerClass(new TwigRender());
    $controllerClass->runAction($actionName);
} else {
    echo "Контроллер не существует";
}



