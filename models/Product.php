<?php

namespace app\models;

class Product extends Model
{
public $id;
public $name;
public $description;
public $price;

    /**
     * @param $name
     * @param $description
     * @param $price
     */
    public function __construct($name = null, $description = null, $price = null)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    protected function getTableName()
{
    return 'products';
}
}