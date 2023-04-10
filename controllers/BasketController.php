<?php

namespace app\controllers;

use app\models\Basket;

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
        // TODO использовать request
        $id = $_GET['id'];
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
}