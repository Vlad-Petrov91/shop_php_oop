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
            App::call()->session->__set('userId', $user->id);
            App::call()->session->__set('userName', $user->name);
            App::call()->session->__set('isAdmin', $user->isAdmin);
            return true;
        }
        return false;
    }

    public function isAuth()
    {
        return isset($_SESSION['login']);
    }

    public function isAdmin()
    {
        return $_SESSION['isAdmin'];
    }

    public function getLogin()
    {
        return $_SESSION['login'];
    }

    public function getName()
    {
        return $_SESSION['userName'];
    }

    public function getUserId()
    {
        return $_SESSION['userId'];
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