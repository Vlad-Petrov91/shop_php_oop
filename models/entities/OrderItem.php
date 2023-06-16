<?php

namespace app\models\entities;

use app\models\Model;

class OrderItem extends Model
{
    protected ?int $id;
    protected ?int $productId;
    protected ?int $orderId;
    protected ?int $quantity;
    protected ?int $price;

    protected $props = [
        'productId' => false,
        'orderId' => false,
        'quantity' => false,
        'price' => false
    ];


    public function __construct($productId = null, $orderId = null, $quantity = null, $price = null)
    {
        $this->productId = $productId;
        $this->orderId = $orderId;
        $this->quantity = $quantity;
        $this->price = $price;
    }

}