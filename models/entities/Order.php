<?php

namespace app\models\entities;

use app\models\Model;

class Order extends Model
{
    protected $id;
    protected $user_id;
    protected $status;

    protected $name;

    protected $phone;

    protected $address;
    protected $uniq_id;


    protected $props = [
        'user_id' => false,
        'status' => false,
        'name' => false,
        'phone' => false,
        'address' => false,
        'uniq_id' => false
    ];


    /**
     * @param $user_id
     * @param $status
     * @param $name
     * @param $phone
     * @param $address
     * @param $uniq_id
     */
    public function __construct($user_id = null, $status = null, $name = null, $phone = null, $address = null, $uniq_id = null)
    {
        $this->user_id = $user_id;
        $this->status = $status;
        $this->name = $name;
        $this->phone = $phone;
        $this->address = $address;
        $this->uniq_id = $uniq_id;
    }


}