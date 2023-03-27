<?php

namespace app\controllers;

use app\models\Basket;

class BasketController extends Controller
{

    public function actionIndex()
    {
        $basket = Basket::getBasket();
        echo $this->render('basket/index',[
            'basket' => $basket
        ]);
    }
}