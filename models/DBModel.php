<?php

namespace app\models;

use app\engine\Db;

abstract class DBModel extends Model
{
    protected abstract static function getTableName();

    public function insert()
    {
        $attributes = [];
        $params = [];

        foreach ($this as $key => $value) {
            if ($key === 'id') continue;
            $attributes[] = $key;
            $params[':' . $key] = $value;
        }

        $attributes = implode(',', $attributes);
        $placeHolders = implode(',', array_keys($params));
        $tableName = static::getTableName();

        $sql = "INSERT INTO {$tableName} ({$attributes}) VALUES ({$placeHolders})";
        Db::getInstance()->execute($sql, $params);
        $this->id = Db::getInstance()->lastInsertId();
        return $this;
    }

    public function update()
    {
        //TODO сделать update
    }

    public function save()
    {
        //TODO тоже сделать
        //if() $this->insert; else $this->update();
    }

    public function delete()
    {
        $tableName = static::getTableName();
        $sql = "DELETE FROM {$tableName} WHERE id = :id";
        return Db::getInstance()->execute($sql, ['id' => $this->id]);
    }

    public static function getOne($id)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        //return Db::getInstance()->queryOne($sql, ['id' => $id]);
        return Db::getInstance()->queryOneObject($sql, ['id' => $id], static::class);
    }

    public static function getAll()
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return Db::getInstance()->queryAll($sql);
    }
}