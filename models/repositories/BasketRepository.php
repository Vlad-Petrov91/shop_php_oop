<?php

namespace app\models\repositories;

use app\engine\App;
use app\models\entities\Basket;
use app\models\Repository;

class BasketRepository extends Repository
{
    public function getBasket($sessionId)
    {
        $sql = "SELECT basket.id as basketId, products.id as prodId, products.name, products.description, basket.quantity, products.price, basket.quantity * products.price as totalPrice FROM `basket`, `products` WHERE `sessionId` = :sessionId AND basket.productId = products.id";
        return App::call()->db->queryAll($sql, ['sessionId' => $sessionId]);
    }

    public function deleteBasket($sessionId)
    {
        $sql = "DELETE FROM {$this->getTableName()} WHERE `sessionId` = :sessionId";
        return App::call()->db->execute($sql, ['sessionId' => $sessionId]);
    }


    public function getBasketItem($sessionId, $productId)
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE `sessionId` = :sessionId AND productId = :productId";
        return App::call()->db->queryOneObject($sql, [
            'sessionId' => $sessionId,
            'productId' => $productId
        ], Basket::class);
    }

    public function getBasketItemAuth($userId, $productId)
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE userId = :userId AND productId = :productId";
        return App::call()->db->queryOne($sql, [
            'userId' => $userId,
            'productId' => $productId
        ]);
    }


    public function getCountBasketItem($sessionId, $userId, $productId)
    {
        $sql = "SELECT `count` FROM {$this->getTableName()} WHERE `sessionId` = :sessionId AND userId = :userId AND productId = :productId";
        return App::call()->db->queryColumn($sql, [
            'sessionId' => $sessionId,
            'userId' => $userId,
            'productId' => $productId
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