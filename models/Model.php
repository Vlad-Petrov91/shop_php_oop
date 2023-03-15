<?php

namespace app\models;

use app\engine\Db;
use app\interfaces\IModel;

abstract class Model implements IModel
{
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function insert()
    {
        $attributes = [];
        $placeHolders = [];
        $values = [];

        foreach ($this as $key => $value) {
        if($key === 'id') continue;
        $attributes[] = $key;
        $placeHolders[] = ':' . $key;
        $values[] = $value;
        }
        $attributes = implode(',', $attributes);
        $placeHolders1 = implode(',',$placeHolders);
        $sql = "INSERT INTO {$this->getTableName()} ({$attributes}) VALUES ({$placeHolders1})";
//        die(var_dump($sql));
        $params = array_combine($placeHolders,$values);
        Db::getInstance()->execute($sql, $params);
        $this->id = Db::getInstance()->lastInsertId();
        return $this;
    }

    public function delete()
    {
        $id = $this->id;
        $sql = "DELETE FROM {$this->getTableName()} WHERE id = :id";
        return Db::getInstance()->execute($sql, ['id'=>$id]);
    }

    public function getOne($id)
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE id = :id";
       //return Db::getInstance()->queryOne($sql, ['id' => $id]);
         return Db::getInstance()->queryOneObject($sql, ['id' => $id], static::class);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->getTableName()}";
        return Db::getInstance()->queryAll($sql);
    }

    protected abstract function getTableName();

}