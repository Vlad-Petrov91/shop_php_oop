<?php

namespace app\models;

class Basket extends DBModel
{
    protected $id;
    protected $session_id;
    protected $product_id;
    protected $props = [
        'session_id' => false,
        'product_id' => false
    ];

    public static function getBasket()
    {
        return [];
    }

    protected static function getTableName()
    {
        return 'basket';
    }
}