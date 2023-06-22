<?php

namespace app\models\entities;

use app\models\Model;

class Order extends Model
{
    protected $id;
    protected $userId;
    protected $status;

    protected $name;

    protected $phone;

    protected $address;
    protected $uniqId;
    protected $date;


    protected $props = [
        'userId' => false,
        'status' => false,
        'name' => false,
        'phone' => false,
        'address' => false,
        'uniqId' => false
    ];


    /**
     * @param $userId
     * @param $status
     * @param $name
     * @param $phone
     * @param $address
     * @param $uniqId
     */
    public function __construct($userId = null, $status = null, $name = null, $phone = null, $address = null, $uniqId = null)
    {
        $this->userId = $userId;
        $this->status = $status;
        $this->name = $name;
        $this->phone = $phone;
        $this->address = $address;
        $this->uniqId = $uniqId;
    }
}