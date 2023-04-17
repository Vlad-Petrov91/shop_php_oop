<?php

namespace app\controllers;

use app\engine\Request;
use app\engine\Session;
use app\models\entities\Basket;
use app\models\repositories\BasketRepository;

class BasketController extends Controller
{

    public function actionIndex()
    {
        $session_id = (new Session())->getId();
        $basket = (new BasketRepository())->getBasket($session_id);
        echo $this->render('basket/index', [
            'basket' => $basket
        ]);
    }

    public function actionAdd()
    {
        $id = (new Request())->params['id'];
        $session_id = (new Session())->getId();
        $basket = new Basket($session_id, $id);
        (new BasketRepository())->save($basket);

        $responce = [
            'status' => 'ok',
            'count' => (new BasketRepository())->getCountWhere('session_id', $session_id),
        ];
        echo json_encode($responce, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        die();
    }

    public function actionDelete()
    {
        $id = (new Request())->params['id'];
        $session_id = (new Session())->getId();
        $basket = (new BasketRepository())->getOne($id);
        $status = 'ok';

        if (!$basket) {
            $status = 'error';
        }
        if ($session_id == $basket->session_id) {
            (new BasketRepository())->delete($basket);
        } else {
            $status = 'error';
        }
        $responce = [
            'status' => $status,
            'count' => (new BasketRepository())->getCountWhere('session_id', $session_id),
            'id' => $id
        ];
        echo json_encode($responce, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        die();
    }
}