<?php

namespace app\models\repositories;

use app\engine\App;
use app\models\Repository;
use app\models\entities\Order;

class OrderRepository extends Repository
{
    public function getOrderList($user_id) {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE `user_id` = :user_id";
        return App::call()->db->queryAll($sql,['user_id' => $user_id]);
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