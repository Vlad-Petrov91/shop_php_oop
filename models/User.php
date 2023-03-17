<?php

namespace app\models;

class User extends DBModel
{
    public $id;
    public $login;
    public $pass;

    protected  static function getTableName()
    {
        return 'users';
    }
}