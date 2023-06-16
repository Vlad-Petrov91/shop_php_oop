<?php

namespace app\controllers;

use app\engine\App;
use app\exceptions\InvalidArgumentException;
use app\models\entities\User;

class RegistrationController extends Controller
{

    public function actionIndex()
    {
        echo $this->render('user/registration');
    }

    public function actionSignUp($params = [])
    {
        try {
            $user = $this->signUp($params);
        } catch (InvalidArgumentException $e) {
            echo $this->render('user/registration', array_merge($params, ['error' => $e->getMessage()]));
            return;
        }
        if ($user instanceof User) {
            App::call()->userRepository->insert($user);
            echo $this->render('user/signUpSuccessful');
            return;
        }
        die();
    }

    public function signUp(array $params)
    {

        if (empty($params['login'])) {
            throw new InvalidArgumentException('Не передан login');
        }
        if (!preg_match('/^[a-zA-Z0-9]+$/', $params['login'])) {
            throw new InvalidArgumentException('Login может состоять только из символов латинского алфавита и цифр');
        }
        if (empty($params['email'])) {
            throw new InvalidArgumentException('Не передан email');
        }
        if (!filter_var($params['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email некорректен');
        }
        if (empty($params['pass'])) {
            throw new InvalidArgumentException('Не передан password');
        }
        if (mb_strlen($params['pass']) < 3) {
            throw new InvalidArgumentException('Пароль должен быть не менее 8 символов');
        }
        if ($params['passRepeat'] !== $params['pass']) {
            throw new InvalidArgumentException('Пароли не совпадают');
        }
        if (App::call()->userRepository->findOneByColumn('email', $params['email'])) {
            throw new InvalidArgumentException('Пользователь с таким email уже существует');
        }
        if (App::call()->userRepository->findOneByColumn('login', $params['login'])) {
            throw new InvalidArgumentException('Пользователь с таким login уже существует');
        }

        $login = $params['login'];
        $pass = password_hash($params['pass'], PASSWORD_DEFAULT);
        $email = $params['email'];
        $name = $params['name'];
        $authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $isConfirmed = 0;
        $isAdmin = 0;

        return new User($login, $pass, $email, $name, $authToken, $isConfirmed, $isAdmin);
    }
}