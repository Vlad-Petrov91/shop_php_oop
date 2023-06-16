<?php

namespace app\controllers;

use app\engine\App;
use app\engine\Request;
use app\engine\Session;
use app\exceptions\InvalidArgumentException;
use app\models\entities\User;
use app\models\repositories\UserRepository;

class AuthController extends Controller
{

    public function actionIndex()
    {
        echo $this->render('user/authorization');
    }

    public function actionLogin($params = [])
    {
//        $login = App::call()->request->params['login'];
//        $pass = App::call()->request->params['pass'];

        try {
            $this->signIn($params);
        } catch (InvalidArgumentException $e) {
            echo $this->render('user/authorization', array_merge($params, ['error' => $e->getMessage()]));
        }
        die();
    }

    public function signIn(array $params)
    {
        if (empty($params['login'])) {
            throw new InvalidArgumentException('Не передан login');
        }
        if (empty($params['pass'])) {
            throw new InvalidArgumentException('Не передан password');
        }
        $login = $params['login'];
        $pass = $params['pass'];
        if (App::call()->userRepository->Auth($login, $pass)) {
            header("Location: /");
            die();
        } else {
            throw new InvalidArgumentException('Неверный логин или пароль');
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