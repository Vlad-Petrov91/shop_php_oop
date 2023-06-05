<?php

namespace app\models\repositories;

use app\engine\Session;
use app\exceptions\InvalidArgumentException;
use app\models\entities\User;
use app\models\Repository;
use app\engine\App;

class UserRepository extends Repository
{
    public function Auth($login, $pass)
    {
        $user = $this->getWhere('login', $login);
        if ($user && password_verify($pass, $user->pass)) {
            App::call()->session->__set('login', $login);
            App::call()->session->__set('user_id', $user->id);
            return true;
        }
        return false;
    }

    public function isAuth()
    {
        return isset($_SESSION['login']);
    }

    public function getLogin()
    {
        return $_SESSION['login'];
    }

    public function getUserId()
    {
        return $_SESSION['user_id'];
    }

    protected function getTableName()
    {
        return 'users';
    }

    protected function getEntityClass()
    {
        return User::class;
    }
}