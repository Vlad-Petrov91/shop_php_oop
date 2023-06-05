<?php

namespace app\controllers;

use app\engine\App;
use app\engine\Session;
use app\models\entities\Basket;

class BasketController extends Controller
{

    public function actionIndex()
    {
        $session_id = App::call()->session->getId();
        $basket = App::call()->basketRepository->getBasket($session_id);
        $session_id = App::call()->session->getId();
        echo $this->render('basket/index', [
            'basket' => $basket,
            'session_id' => $session_id,
        ]);
    }

    public function actionAdd($params = [])
    {
        //$id = App::call()->request->params['id'];
        $product_id = intval($params['id']);
        $session_id = App::call()->session->getId();
        $user_id = App::call()->session->user_id;

        $basket = App::call()->basketRepository->getBasketItem($session_id, $product_id);
        if($basket) {
            $basket->quantity +=1;
        } else {
            $quantity = 1;
            $basket = new Basket($session_id, $product_id, $user_id, $quantity);
        }

        // $count = 1;
        //   $count = App::call()->basketRepository->getCountBasketItem($session_id, $user_id, $id) ?? 1;
        //     $basket = App::call()->basketRepository->getBasketItemAuth($user_id, $id) ?? App::call()->basketRepository->getBasketItem($session_id, $id);


        App::call()->basketRepository->save($basket);

        $responce = [
            'status' => 'ok',
            'count' => App::call()->basketRepository->getCountWhere('session_id', $session_id),
        ];
        echo json_encode($responce, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        die();
    }

    public function actionDelete()
    {
        $id = App::call()->request->params['id'];
        $session_id = App::call()->session->getId();
        $basket = App::call()->basketRepository->getOne($id);
        $status = 'ok';

        if (!$basket) {
            $status = 'error';
        }
        if ($session_id == $basket->session_id) {
            App::call()->basketRepository->delete($basket);
        } else {
            $status = 'error';
        }
        $responce = [
            'status' => $status,
            'count' => App::call()->basketRepository->getCountWhere('session_id', $session_id),
            'id' => $id
        ];
        echo json_encode($responce, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        die();
    }
}