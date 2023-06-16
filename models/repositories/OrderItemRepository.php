<?php

namespace app\models\repositories;

use app\engine\App;
use app\models\entities\OrderItem;
use app\models\Repository;

class OrderItemRepository extends Repository
{

    public function addOrderList($basketId)
    {
        $sql = "SELECT basket.productId, products.price, basket.quantity FROM `basket`, `products` WHERE  basket.id = :id AND basket.productId = products.id";
        return App::call()->db->queryOneObject($sql, ['id' => $basketId], OrderItem::class);
    }

    protected function getTableName(): string
    {
        return 'order_items';
    }

    protected function getEntityClass(): string
    {
        return OrderItem::class;
    }
}