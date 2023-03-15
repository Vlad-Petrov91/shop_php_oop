<?php

namespace app\engine;

use app\traits\TSingletone;
use PDO;

class Db
{
    private $config = [
        'driver' => 'mysql',
        'host' => 'localhost:3306',
        'login' => 'root',
        'password' => '',
        'database' => 'gb',
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

    private function query($query, $params)
    {
        $STH = $this->getConnection()->prepare($query);
        $STH->execute($params);
        return $STH;
    }

    public function queryOne($sql, $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }

    public function queryAll($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function execute($sql, $params = [])
    {
        return $this->query($sql, $params)->rowCount();
    }

    public function queryOneObject($sql,$params,$class)
    {
        $STH = $this->query($sql,$params);
        $STH->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,$class);
        return $STH->fetch();
    }

}