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

        foreach ($this->props as $key => $value) {
            $attributes[] = $key;
            $params[':' . $key] = $this->$key;
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
        $attributes = [];
        $params[':id'] = $this->id;
        foreach ($this->props as $key => $value) {
            if ($value) {
                $attributes[] = "`{$key}`=:{$key}";
                $params[':' . $key] = $this->$key;
                $this->props[$key] = false;
            }
        }
        $attributes = implode(',', $attributes);
        $tableName = static::getTableName();
        $sql = "UPDATE {$tableName} SET {$attributes} WHERE `id` = :id";
        Db::getInstance()->execute($sql, $params);
        return $this;
    }

    public function save()
    {
        if (is_null($this->id)) {
            $this->insert();
        } else {
            $this->update();
        }
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

    public static function getLimit($limit)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} LIMIT 0, ?";
        return Db::getInstance()->queryLimit($sql, $limit);
    }
}