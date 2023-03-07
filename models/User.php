<?php

namespace app\models;

class User extends Model
{
    public $id;
    public $login;
    public $pass;

    protected function getTableName()
    {
        return 'users';
    }
}