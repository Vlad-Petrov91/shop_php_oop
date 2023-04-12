<?php

namespace app\controllers;

use app\models\Basket;
use app\engine\Request;

class BasketController extends Controller
{

    public function actionIndex()
    {
        $session_id = session_id();
        $basket = Basket::getBasket($session_id);
        echo $this->render('basket/index', [
            'basket' => $basket
        ]);
    }

    public function actionAdd()
    {
        $id = (new Request())->__get('params')['id'];
        $session_id = session_id();
        $basket = new Basket($session_id, $id);
        $basket->save();

        $responce = [
            'status' => 'ok',
            'count' => Basket::getCountWhere('session_id', $session_id),
        ];
        echo json_encode($responce, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        die();
    }

    public function actionDelete()
    {
        $id = (new Request())->__get('params')['id'];
        $session_id = session_id();
        Basket::delete($id);
        $responce = [
            'status' => 'ok',
            'count' => Basket::getCountWhere('session_id', $session_id),
            'id' => $id
        ];
        echo json_encode($responce, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        die();
    }
}