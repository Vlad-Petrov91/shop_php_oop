<?php

return [
    '/' => ['method' => 'GET', 'controller' => 'Index', 'action' => 'Index'],
    '/catalog' => ['method' => 'GET', 'controller' => 'Product', 'action' => 'Catalog'],
    '/catalog/card/' => ['method' => 'GET', 'controller' => 'Product', 'action' => 'Card'],
    '/basket' => ['method' => 'GET', 'controller' => 'Basket', 'action' => 'Index'],
    '/basket/add/' =>['method' => 'GET', 'controller' => 'Basket', 'action' => 'Add'],
    '/auth/login' =>['method' => 'POST', 'controller' => 'Auth', 'action' => 'Login'],
    '/auth/logout' =>['method' => 'GET', 'controller' => 'Auth', 'action' => 'Logout'],
];
