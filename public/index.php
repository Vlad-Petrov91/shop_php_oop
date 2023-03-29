<?php

use app\engine\Autoload;
use app\engine\Db;
use app\models\{User, Product};
use app\engine\{Render, TwigRender};

include __DIR__ . "/../engine/Autoload.php";
include __DIR__ . "/../config/config.php";

spl_autoload_register([new Autoload(), 'loadClass']);
require_once '../vendor/autoload.php';

$controllerName = $_GET['c'] ?: 'index';
$actionName = $_GET['a'];

$controllerClass = CONTROLLER_NAMESPACE . ucfirst($controllerName) . "Controller";

if ($controllerClass) {
    $controllerClass = new $controllerClass(new TwigRender());
    $controllerClass->runAction($actionName);
} else {
    echo "Контроллер не существует";
}



