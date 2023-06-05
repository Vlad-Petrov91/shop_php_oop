<?php

namespace app\controllers;

use app\controllers\Controller;
use app\engine\App;
use app\models\entities\Order;

class OrderController extends Controller
{
    public function actionIndex($params = [])
    {
        $userId = App::call()->userRepository->getUserId() ?? App::call()->session->getId();
        $orderList = App::call()->orderRepository->getOrderList($userId);
        echo $this->render('orders/index', [
            'orderList' => $orderList,
        ]);
    }

    public function actionAdd($params = [])
    {
        if (App::call()->request->method === 'GET') {
            //$id = App::call()->request->params['id'];
            $session_id = App::call()->session->getId();
            $basket = App::call()->basketRepository->getBasket($session_id);
            echo $this->render('orders/addOrder', [
                'order' => $basket,
            ]);
        }
        if (App::call()->request->method === 'POST') {
            $user_id = App::call()->request->params['user_id'] ?? 1;
            $status = 'Оформлен';
            $name = App::call()->request->params['name'];
            $phone = App::call()->request->params['phone'];
            $address = App::call()->request->params['address'];
            $uniq_id = uniqid();

            $order = new Order($user_id,$status,$name,$phone,$address,$uniq_id);
            App::call()->orderRepository->save($order);

            $responce = [
                'status' => 'ok',
            ];
            echo json_encode($responce, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            die();

        }


        $responce = [
            'status' => 'ok',
            'count' => App::call()->basketRepository->getCountWhere('session_id', $session_id),
        ];
        echo json_encode($responce, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        die();
    }
}