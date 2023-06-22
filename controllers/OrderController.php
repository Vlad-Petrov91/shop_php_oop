<?php

namespace app\controllers;

use app\controllers\Controller;
use app\engine\App;
use app\models\entities\Order;
use app\models\entities\OrderItem;

class OrderController extends Controller
{
    public function actionIndex($params = [])
    {
        $userId = $userId = App::call()->session->userId;
        $orderList = App::call()->orderRepository->getOrders($userId);
        echo $this->render('orders/index', [
            'orderList' => $orderList,
        ]);
    }

    public function actionInfo($params = [])
    {
        $orderId = $params['id'];
        $orderItems = App::call()->orderRepository->getOrderList($orderId);
        echo $this->render('orders/order', [
            'orderId' => $orderId,
            'orderItems' => $orderItems,
        ]);
    }

    public function actionAdd($params = [])
    {
        if (App::call()->request->method === 'GET') {
            //$id = App::call()->request->params['id'];
            $sessionId = App::call()->session->getId();
            $basket = App::call()->basketRepository->getBasket($sessionId);
            $isAuth = App::call()->userRepository->isAuth();
            $userName = App::call()->userRepository->getName();
            echo $this->render('orders/addOrder', [
                'order' => $basket,
                'isAuth' => $isAuth,
                'userName' => $userName
            ]);
        }
        if (App::call()->request->method === 'POST') {
            $sessionId = App::call()->session->getId();
            $userId = App::call()->session->userId;
            $status = 'Оформлен';
            $name = App::call()->userRepository->getName();
            $phone = App::call()->request->params['phone'];
            $address = App::call()->request->params['address'];
            $uniqId = uniqid();

            $order = new Order($userId, $status, $name, $phone, $address, $uniqId);
            App::call()->orderRepository->insert($order);
            $id = App::call()->db->lastInsertId();

            $orderItems = App::call()->basketRepository->getBasket($sessionId);
            $orderItemsArray = [];
            foreach ($orderItems as $item) {
                $orderParams = App::call()->orderItemRepository->addOrderList($item['basketId']);
                $orderParams->orderId = $id;
                App::call()->orderItemRepository->insert($orderParams);
            }
            App::call()->basketRepository->deleteBasket($sessionId);

            header("Location: /orders");
            die();

        }
    }

    public function actionDelete($params = [])
    {
        $order = App::call()->orderRepository->getOne($params['id']);
        $status = 'ok';

        if (App::call()->userRepository->isAdmin()) {
            App::call()->orderRepository->delete($order);
        } else {
            $status = 'error';
        }
        $responce = [
            'status' => $status,
            'id' => $order->id,
        ];
        echo json_encode($responce, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        die();
    }

    public function actionEditOrder($params = [])
    {
        if (App::call()->userRepository->isAdmin()) {

            if (App::call()->request->method == 'POST') {

//                $replace = '/(?<=productId)\d+/';
//                $pattern = '/productId[0-9]+/';
                $orderItems = array_filter($params, function ($key) {
                    return preg_match('/productId[0-9]+/', $key);
                }, ARRAY_FILTER_USE_KEY);

//                $answer = preg_filter($pattern, $replace, $params);


                $formatedOrderItems = [];
                foreach ($orderItems as $key => $value) {
                    preg_match('/(?<=productId)\d+/', $key, $mathes);
                    $formatedOrderItems[$mathes[0]] = $value;
                    $orderItem = App::call()->orderItemRepository->getOne($mathes[0]);
                    if ($orderItem->quatity !== (int)$value) {
                        $orderItem->quantity = (int)$value;
                        App::call()->orderItemRepository->save($orderItem);
                    }

                }

                $order = App::call()->orderRepository->getOne($params['id']);
                foreach ($params as $key => $value) {
                    if (property_exists($order, $key) && $order->$key !== $value) {
                        $order->$key = $value;
                    }
                }


                App::call()->orderRepository->save($order);
                $page = $params['page'] ?? 0;
                $ordersList = App::call()->orderRepository->getLimit(($page + 1) * 3);

                echo $this->render('admin/index', [
                    'ordersList' => $ordersList,
                    'page' => ++$page
                ]);
                die();
            }

            $orderInfo = App::call()->orderRepository->getOrderInfo($params['id']);
            $orderItems = App::call()->orderRepository->getOrderList($params['id']);
            echo $this->render('orders/editOrder', [
                'orderInfo' => $orderInfo,
                'order' => $orderItems,
            ]);
        } else {
            echo '404';
        }
    }
}