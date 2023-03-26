<?php

use app\engine\Autoload;
use app\engine\Db;
use app\models\{User, Product};


include __DIR__ . "/../engine/Autoload.php";
include __DIR__ . "/../config/config.php";

spl_autoload_register([new Autoload(), 'loadClass']);

$controllerName = $_GET['c'] ?: 'product';
$actionName = $_GET['a'];

$controllerClass = CONTROLLER_NAMESPACE . ucfirst($controllerName) . "Controller";

if($controllerClass){
    $controllerClass = new $controllerClass();
    $controllerClass->runAction($actionName);
} else {
    echo "Контроллер не существует";
}


//$product = new Product();
//$product = $product->getOne(1);

$product = Product::getOne(1);
$product->price = 99;
$product->save();



die();
//$user = new User();
//var_dump($user->getOne(1));


//var_dump($product);
//$product->delete();
//var_dump($product->insert());


