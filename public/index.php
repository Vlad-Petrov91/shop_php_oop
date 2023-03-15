<?php

use app\engine\Autoload;
use app\engine\Db;
use app\models\{User, Product};


include __DIR__ . "/../engine/Autoload.php";
include __DIR__ . "/../config/config.php";

spl_autoload_register([new Autoload(), 'loadClass']);


//$user = new User();
//var_dump($user->getOne(1));

$product = new Product();
$product = $product->getOne(16);
var_dump($product);
//$product->delete();
//var_dump($product->insert());
var_dump($product->getAll());

