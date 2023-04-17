<?php

namespace app\models\repositories;

use app\engine\Session;
use app\models\entities\User;
use app\models\Repository;

class UserRepository extends Repository
{
    public function Auth($login, $pass)
    {
        $user = $this->getWhere('login', $login);
        if ($user && password_verify($pass, $user->pass)) {
            $session = new Session();
            $session->set('login', $login);
            return true;
        }
        return false;
    }

    public function isAuth()
    {
        return isset($_SESSION['login']);
    }

    public function getName()
    {
        return $_SESSION['login'];
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