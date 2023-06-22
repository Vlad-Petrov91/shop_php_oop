<?php

namespace app\models\repositories;

use app\engine\App;
use app\models\entities\OrderItem;
use app\models\Repository;
use app\models\entities\Order;

class OrderRepository extends Repository
{
    public function getOrders($userId)
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE `userId` = :userId";
        return App::call()->db->queryAll($sql, ['userId' => $userId]);
    }

    public function getOrderInfo($id)
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE `id` = :id";
        return App::call()->db->queryOne($sql, ['id' => $id]);
    }

    public function getOrderList($id)
    {
        $sql = "SELECT order_items.id, products.name, order_items.productId,order_items.quantity,order_items.price FROM `products`,`order_items` WHERE order_items.orderId = :id AND products.id = order_items.productId";
        return App::call()->db->queryAll($sql, ['id' => $id]);
    }

    protected function getTableName(): string
    {
        return 'orders';
    }

    protected function getEntityClass(): string
    {
        return Order::class;
    }
}