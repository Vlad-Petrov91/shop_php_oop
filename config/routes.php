<?php

return [
    '/' => ['method' => 'GET', 'controller' => 'Index', 'action' => 'Index'],
    '/catalog' => ['method' => 'GET', 'controller' => 'Product', 'action' => 'Catalog'],
    '/catalog/card/' => ['method' => 'GET', 'controller' => 'Product', 'action' => 'Card'],
    '/basket' => ['method' => 'GET', 'controller' => 'Basket', 'action' => 'Index'],
    '/basket/add/' => ['method' => 'GET', 'controller' => 'Basket', 'action' => 'Add'],
    '/basket/delete/' => ['method' => 'GET', 'controller' => 'Basket', 'action' => 'Delete'],
    '/basket/increase/' => ['method' => 'GET', 'controller' => 'Basket', 'action' => 'IncreaseItem'],
    '/basket/reduce/' => ['method' => 'GET', 'controller' => 'Basket', 'action' => 'ReduceItem'],
    '/auth' => ['method' => 'GET', 'controller' => 'Auth', 'action' => 'Index'],
    '/auth/login' => ['method' => 'POST', 'controller' => 'Auth', 'action' => 'Login'],
    '/auth/logout' => ['method' => 'GET', 'controller' => 'Auth', 'action' => 'Logout'],
    '/registration' => ['method' => 'GET', 'controller' => 'Registration', 'action' => 'Index'],
    '/registration/new' => ['method' => 'POST', 'controller' => 'Registration', 'action' => 'SignUp'],
    '/orders' => ['method' => 'GET', 'controller' => 'Order', 'action' => 'Index'],
    '/orders/info/' => ['method' => 'GET', 'controller' => 'Order', 'action' => 'Info'],
    '/orders/add/' => ['method' => ['GET','POST'], 'controller' => 'Order', 'action' => 'Add'],
    '/orders/delete/' => ['method' => ['POST'], 'controller' => 'Order', 'action' => 'Delete'],
    '/admin' => ['method' => ['GET','POST'], 'controller' => 'Admin', 'action' => 'Index'],
    '/admin/orders/edit-order/' => ['method' => ['GET','POST'], 'controller' => 'Order', 'action' => 'EditOrder'],
];
