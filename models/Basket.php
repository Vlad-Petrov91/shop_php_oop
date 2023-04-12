<?php

namespace app\models;
use app\engine\Db;

class Basket extends DBModel
{
    protected $id;
    protected $session_id;
    protected $product_id;
    protected $props = [
        'session_id' => false,
        'product_id' => false
    ];

    public function __construct($session_id = null, $product_id = null)
    {
        $this->session_id = $session_id;
        $this->product_id = $product_id;
    }

    public static function getBasket($session_id)
    {
        $sql = "SELECT basket.id as basket_id, products.id as prod_id, products.name, products.description, products.price FROM `basket`, `products` WHERE `session_id` = :session_id AND basket.product_id = products.id";
        return Db::getInstance()->queryAll($sql, ['session_id' => $session_id]);
    }

    protected static function getTableName()
    {
        return 'basket';
    }
}