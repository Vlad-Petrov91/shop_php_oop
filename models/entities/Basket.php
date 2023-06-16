<?php

namespace app\models\entities;

use app\engine\Db;
use app\models\Model;

class Basket extends Model
{
    protected $id;
    protected $sessionId;
    protected $userId;
    protected $productId;
    protected $quantity;
    protected $props = [
        'sessionId' => false,
        'userId' =>false,
        'productId' => false,
        'quantity' => false
    ];

    public function __construct($sessionId = null, $productId = null, $userId = null, $quantity = null)
    {
        $this->sessionId = $sessionId;
        $this->productId = $productId;
        $this->userId = $userId;
        $this->quantity =$quantity;
    }
}