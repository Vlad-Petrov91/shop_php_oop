<?php

namespace app\controllers;

use app\engine\App;
use app\engine\Request;
use app\engine\Session;
use app\models\repositories\UserRepository;

class AuthController extends Controller
{
    public function actionLogin()
    {
        $login = App::call()->request->params['login'];
        $pass = App::call()->request->params['pass'];

        if ((new UserRepository())->Auth($login, $pass)) {
            header("Location: /");
            die();
        } else {
            die("Не верный логин или пароль");
        }
    }

    public function actionLogout()
    {
        $session = new Session();
        $session->regenerate();
        $session->destroy();
        header("Location: /");
        die();
    }
}