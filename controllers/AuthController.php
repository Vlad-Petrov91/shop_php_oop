<?php

namespace app\controllers;

use app\engine\App;
use app\engine\Request;
use app\engine\Session;
use app\models\repositories\UserRepository;

class AuthController extends Controller
{
    public function actionLogin($params = [])
    {
//        $login = App::call()->request->params['login'];
//        $pass = App::call()->request->params['pass'];

        $login = $params['login'];
        $pass = $params['pass'];

        if (App::call()->userRepository->Auth($login, $pass)) {
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