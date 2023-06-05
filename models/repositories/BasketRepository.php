<?php

namespace app\models\repositories;

use app\engine\App;
use app\models\entities\Basket;
use app\models\Repository;

class BasketRepository extends Repository
{
    public function getBasket($session_id)
    {
        $sql = "SELECT basket.id as basket_id, products.id as prod_id, products.name, products.description, products.price FROM `basket`, `products` WHERE `session_id` = :session_id AND basket.product_id = products.id";
        return App::call()->db->queryAll($sql, ['session_id' => $session_id]);
    }

    public function getBasketItem($session_id, $product_id) {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE `session_id` = :session_id AND product_id = :product_id";
        return App::call()->db->queryOneObject($sql, [
            'session_id' => $session_id,
            'product_id' => $product_id
        ], Basket::class);
    }

    public function getBasketItemAuth($user_id, $product_id) {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE user_id = :user_id AND product_id = :product_id";
        return App::call()->db->queryOne($sql, [
            'user_id' => $user_id,
            'product_id' => $product_id
        ]);
    }


    public function getCountBasketItem($session_id, $user_id, $product_id)
    {
        $sql = "SELECT `count` FROM {$this->getTableName()} WHERE `session_id` = :session_id AND user_id = :user_id AND product_id = :product_id";
        return App::call()->db->queryColumn($sql, [
            'session_id' => $session_id,
            'user_id' => $user_id,
            'product_id' => $product_id
        ]);
    }

    protected function getTableName()
    {
        return 'basket';
    }

    protected function getEntityClass()
    {
        return Basket::class;
    }
}