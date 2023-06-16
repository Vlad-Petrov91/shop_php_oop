<?php

use app\engine\App;
use app\engine\Db;
use app\engine\Request;
use app\models\repositories\UserRepository;
use app\models\repositories\ProductRepository;
use app\models\repositories\BasketRepository;
use app\models\repositories\OrderRepository;
use app\models\repositories\OrderItemRepository;
use app\engine\Session;
use app\engine\TwigRender;
use app\engine\Render;
use app\engine\Router;

//define("ROOT", dirname(__DIR__));
//define("DS", DIRECTORY_SEPARATOR);
//define("CONTROLLER_NAMESPACE", "app\\controllers\\");
//define("VIEWS_DIR", '../views/');

return [
    'root' => dirname(__DIR__),
    'controllers_namespaces' => 'app\\controllers\\',
    'product_per_page' => 2,
    'views_dir' => dirname(__DIR__) . "/views/",
//    'twig_views_dir' => dirname(__DIR__) . "/templates/",
// TODO добавить twigRender
    'components' => [
        'db' => [
            'class' => Db::class,
            'driver' => 'mysql',
            'host' => 'localhost',
            'login' => 'root',
            'password' => '',
            'database' => 'shop',
            'charset' => 'utf8'
        ],
        'request' => [
            'class' => Request::class,
        ],
        'basketRepository' => [
            'class' => BasketRepository::class,
        ],
        'userRepository' => [
            'class' => UserRepository::class,
        ],
        'productRepository' => [
            'class' => ProductRepository::class,
        ],
        'orderRepository' => [
            'class' => OrderRepository::class,
        ],
        'orderItemRepository' => [
            'class' => OrderItemRepository::class,
        ],
        'session' => [
            'class' => Session::class,
        ],
        'twigRender' => [
            'class' => TwigRender::class,
        ],
        'render' => [
            'class' => Render::class,
        ],
        'router' => [
            'class' => Router::class,
        ]
    ]
];