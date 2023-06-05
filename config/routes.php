<?php

return [
    '/' => ['method' => 'GET', 'controller' => 'Index', 'action' => 'Index'],
    '/catalog' => ['method' => 'GET', 'controller' => 'Product', 'action' => 'Catalog'],
    '/catalog/card/' => ['method' => 'GET', 'controller' => 'Product', 'action' => 'Card'],
    '/basket' => ['method' => 'GET', 'controller' => 'Basket', 'action' => 'Index'],
    '/basket/add/' => ['method' => 'GET', 'controller' => 'Basket', 'action' => 'Add'],
    '/basket/delete/' => ['method' => 'GET', 'controller' => 'Basket', 'action' => 'Delete'],
    '/auth/login' => ['method' => 'POST', 'controller' => 'Auth', 'action' => 'Login'],
    '/auth/logout' => ['method' => 'GET', 'controller' => 'Auth', 'action' => 'Logout'],
    '/registration' => ['method' => 'GET', 'controller' => 'Registration', 'action' => 'Index'],
    '/registration/new' => ['method' => 'POST', 'controller' => 'Registration', 'action' => 'SignUp'],
    '/orders' => ['method' => 'GET', 'controller' => 'Order', 'action' => 'Index'],
    '/orders/add/' => ['method' => ['GET','POST'], 'controller' => 'Order', 'action' => 'Add'],
];
