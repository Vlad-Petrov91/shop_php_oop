<?php

namespace app\engine;

use app\traits\TSingletone;
use PDO;

class Db
{
    private array $config = [
        'driver' => 'mysql',
        'host' => 'localhost:3306',
        'login' => 'root',
        'password' => '',
        'database' => 'shop',
        'charset' => 'utf8',
    ];

    private $connection = null;

    use TSingletone;

    public function lastInsertId()
    {
        return $this->getConnection()->lastInsertId();
    }

    private function prepareDsnString()
    {
        return sprintf("%s:host=%s;dbname=%s;charset=%s",
            $this->config['driver'],
            $this->config['host'],
            $this->config['database'],
            $this->config['charset']
        );
    }

    private function getConnection()
    {
        if (is_null($this->connection)) {
            $this->connection = new \PDO($this->prepareDsnString(),
                $this->config['login'],
                $this->config['password']
            );
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        return $this->connection;
//        $db = new \PDO("mysql:host=localhost;dbname=gb", 'root', '');
//        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//        $answer = $db->prepare("SELECT * FROM `shop` WHERE id = :id");
//        $data = ['id' => 3];
//        $answer->execute($data);
//        var_dump($answer->fetch());
    }

    private function query(string $query,array $params)
    {
        $STH = $this->getConnection()->prepare($query);
        $STH->execute($params);
        return $STH;
    }

    public function queryOne(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }

    public function queryAll(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function execute(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->rowCount();
    }

    public function queryOneObject(string $sql, array $params, $class)
    {
        $STH = $this->query($sql, $params);
        $STH->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class);
        return $STH->fetch();
    }

    public function queryLimit(string $sql, int $limit)
    {
        $STH = $this->getConnection()->prepare($sql);
        $STH->bindValue(1, $limit, \PDO::PARAM_INT);
//        $STH->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class);
        $STH->execute();
        return $STH->fetchAll();
    }

}