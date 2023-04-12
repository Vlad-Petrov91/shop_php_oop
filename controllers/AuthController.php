<?php

namespace app\controllers;

use app\engine\Request;
use app\models\User;

class AuthController extends Controller
{
    public function actionLogin()
    {
        $request = new Request();
        $login = $request->__get('params')['login'];
        $pass = $request->__get('params')['pass'];
        if (User::Auth($login, $pass)) {
            header("Location: /");
            die();
        } else {
            die("Не верный логин или пароль");
        }
    }

    public function actionLogout()
    {
        session_regenerate_id();
        session_destroy();
        header("Location: /");
        die();
    }
}