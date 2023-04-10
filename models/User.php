<?php

namespace app\models;

class User extends DBModel
{
    protected $id;
    protected $login;
    protected $pass;
    protected $props = [
        'login' => false,
        'pass' => false,
    ];

    public function __construct($login = null, $pass = null)
    {
        $this->login = $login;
        $this->pass = $pass;
    }

    public static function Auth($login, $pass)
    {
        //TODO проверять пароль только если user не false и захешировать пароль в БД используя password_hash() password_verify()
        $user = User::getWhere('login', $login);
        if ($pass == $user->pass) {
            // TODO переделать на session class
            $_SESSION['login'] = $login;
            return true;
        }
            return false;
    }

    public static function isAuth()
    {
        return isset($_SESSION['login']);
    }

    public static function getName()
    {
        return $_SESSION['login'];
    }

    protected static function getTableName()
    {
        return 'users';
    }
}