<?php

use app\engine\Autoload;
use app\engine\Db;
use app\models\{User, Product};


include __DIR__ . "/../engine/Autoload.php";
include __DIR__ . "/../config/config.php";

spl_autoload_register([new Autoload(), 'loadClass']);


$user = new User();
var_dump($user->getOne(1));

$product = new Product();
var_dump($product->getAll());