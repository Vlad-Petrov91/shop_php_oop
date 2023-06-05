<?php

namespace app\models;

use app\interfaces\IRepository;
use app\engine\App;

abstract class Repository implements IRepository
{
    protected abstract function getTableName();

    protected abstract function getEntityClass();

    public function insert(Model $entity)
    {
        $attributes = [];
        $params = [];

        foreach ($entity->props as $key => $value) {
            $attributes[] = $key;
            $params[':' . $key] = $entity->$key;
        }

        $attributes = implode(',', $attributes);
        $placeHolders = implode(',', array_keys($params));
        $tableName = $this->getTableName();
        $sql = "INSERT INTO {$tableName} ({$attributes}) VALUES ({$placeHolders})";
        App::call()->db->execute($sql, $params);
        $entity->id = App::call()->db->lastInsertId();
        return $this;
    }

    public function update(Model $entity)
    {
        $attributes = [];
        $params[':id'] = $entity->id;
        foreach ($entity->props as $key => $value) {
            if ($value) {
                $attributes[] = "`{$key}`=:{$key}";
                $params[':' . $key] = $entity->$key;
                $entity->props[$key] = false;
            }
        }
        $attributes = implode(',', $attributes);
        $tableName = $this->getTableName();
        $sql = "UPDATE {$tableName} SET {$attributes} WHERE `id` = :id";
        App::call()->db->execute($sql, $params);
        return $this;
    }

    public function save(Model $entity)
    {
        if (is_null($entity->id)) {
            $this->insert($entity);
        } else {
            $this->update($entity);
        }
    }

    public function delete(Model $entity)
    {
        $tableName = $this->getTableName();
        $sql = "DELETE FROM {$tableName} WHERE id = :id";
        return App::call()->db->execute($sql, ['id' => $entity->id]);
    }

    public function getOne($id)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        //return Db::getInstance()->queryOne($sql, ['id' => $id]);
        return App::call()->db->queryOneObject($sql, ['id' => $id], $this->getEntityClass());
    }

    public function getWhere($name, $value)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE {$name} = :value";
        return App::call()->db->queryOneObject($sql, ['value' => $value], $this->getEntityClass());
    }

    public function getCountWhere($name, $value)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT SUM(quantity) as count FROM {$tableName} WHERE {$name} = :value";
        return App::call()->db->queryOne($sql, ['value' => $value])['count'];
    }

    // старая функция подсчета количества продуктов в корзине
//    public function getCountWhere($name, $value)
//    {
//        $tableName = $this->getTableName();
//        $sql = "SELECT count(id) as count FROM {$tableName} WHERE {$name} = :value";
//        return App::call()->db->queryOne($sql, ['value' => $value])['count'];
//    }

    public function getAll()
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return App::call()->db->queryAll($sql);
    }

    public function getLimit($limit)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} LIMIT 0, ?";
        return App::call()->db->queryLimit($sql, $limit);
    }

    public function findOneByColumn($name, $value)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE {$name} = :value LIMIT 1";
        return App::call()->db->queryColumn($sql, ['value' => $value]);
    }
}