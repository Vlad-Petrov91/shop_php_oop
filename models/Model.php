<?php

namespace app\models;

use app\engine\Db;
use app\interfaces\IModel;

abstract class Model implements IModel
{
    protected $props = [];
    public function __set($name, $value)
    {
        //TODO изменять только те поля что есть в классе
        $this->props[$name] = true;
        $this->$name = $value;
    }

    public function __get($name)
    {
        //TODO читать только те поля что есть в классе
        return $this->$name;
    }

    public function __isset($name)
    {
        return isset($this->$name);
    }

}