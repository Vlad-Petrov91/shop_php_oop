<?php

namespace app\models\entities;

use app\engine\Db;
use app\models\Model;

class Basket extends Model
{
    protected $id;
    protected $session_id;
    protected $user_id;
    protected $product_id;
    protected $quantity;
    protected $props = [
        'session_id' => false,
        'user_id' =>false,
        'product_id' => false,
        'quantity' => false
    ];

    public function __construct($session_id = null, $product_id = null, $user_id = null, $quantity = null)
    {
        $this->session_id = $session_id;
        $this->product_id = $product_id;
        $this->user_id = $user_id;
        $this->quantity =$quantity;
    }
}