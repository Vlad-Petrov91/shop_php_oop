<?php

namespace app\controllers;

use app\interfaces\IRender;
use app\models\entities\Basket;
use app\models\entities\User;
use app\models\repositories\BasketRepository;
use app\models\repositories\UserRepository;
use app\engine\App;

abstract class Controller
{
    protected $action;
    protected $defaultAction = 'index';
    protected $render;

    public function __construct(IRender $render)
    {
        $this->render = $render;
    }

    public function runAction($action)
    {
        $this->action = $action ?: $this->defaultAction;
        $method = 'action' . ucfirst($this->action);
        if (method_exists($this, $method)) {
            $this->$method();
        } else {
            die('404 нет такого метода');
        }
    }

    public function render($template, $params = [])
    {
        return $this->renderTemplate('layouts/main', [
            'menu' => $this->renderTemplate('menu', [
                'userName' => App::call()->userRepository->getName(),
                'isAuth' => App::call()->userRepository->isAuth(),
                'count' => App::call()->basketRepository->getCountWhere('session_id', session_id())
            ]),
            'content' => $this->renderTemplate($template, $params)
        ]);
    }

    public function renderTemplate($template, $params = [])
    {
        return $this->render->renderTemplate($template, $params);
    }
}