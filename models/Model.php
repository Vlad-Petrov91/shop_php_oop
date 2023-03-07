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
        foreach ($this as $key => $value) {

        }
        // TODO собрать инсерт пропустить id
        $sql = "INSERT INTO {$this->getTableName()} (`name`, `description`, `price`) VALUES (:name,:price ,[value-3]";
        $params = [];
        $this->id = 11; //TODO получить id lastInsetId
        Db::getInstance()->execute($sql, $params);
        return $this;
    }

    public function delete()
    {
        $id = $this->id;
        $sql = "DELETE";
        return Db::getInstance()->execute($sql, ['id'=>$id]);
    }

    public function getOne($id)
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE id = :id";
        return Db::getInstance()->queryOne($sql, ['id' => $id]);
        // return Db::getInstance()->queryOneObject($sql, ['id' => $id], static::class);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->getTableName()}";
        return Db::getInstance()->queryAll($sql);
    }

    protected abstract function getTableName();

}