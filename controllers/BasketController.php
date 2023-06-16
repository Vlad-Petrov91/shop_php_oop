<?php

namespace app\controllers;

use app\engine\App;
use app\engine\Session;
use app\models\entities\Basket;

class BasketController extends Controller
{

    public function actionIndex()
    {
        $sessionId = App::call()->session->getId();
        $basket = App::call()->basketRepository->getBasket($sessionId);
        $basketTotalPrice = array_sum(array_column($basket, 'totalPrice'));
        echo $this->render('basket/index', [
            'basket' => $basket,
            'sessionId' => $sessionId,
            'basketTotalPrice' => $basketTotalPrice
        ]);
    }

    public function actionAdd($params = [])
    {
        //$id = App::call()->request->params['id'];
        $productId = intval($params['id']);
        $sessionId = App::call()->session->getId();
        $userId = App::call()->session->userId;
        $basket = App::call()->basketRepository->getBasketItem($sessionId, $productId);

        if ($basket) {
            $basket->quantity += 1;
        } else {
            $quantity = 1;
            $basket = new Basket($sessionId, $productId, $userId, $quantity);
        }

        // $count = 1;
        //   $count = App::call()->basketRepository->getCountBasketItem($sessionId, $userId, $id) ?? 1;
        //     $basket = App::call()->basketRepository->getBasketItemAuth($userId, $id) ?? App::call()->basketRepository->getBasketItem($sessionId, $id);


        App::call()->basketRepository->save($basket);

        $responce = [
            'status' => 'ok',
            'count' => App::call()->basketRepository->getCountWhere('sessionId', $sessionId),
        ];
        echo json_encode($responce, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        die();
    }

    public function actionDelete()
    {
        $id = App::call()->request->params['id'];
        $sessionId = App::call()->session->getId();
        $basket = App::call()->basketRepository->getOne($id);
        $status = 'ok';

        if (!$basket) {
            $status = 'error';
        }
        if ($sessionId == $basket->sessionId) {
            App::call()->basketRepository->delete($basket);
            $basket = App::call()->basketRepository->getBasket($sessionId);
            $basketTotalPrice = array_sum(array_column($basket, 'totalPrice'));
        } else {
            $status = 'error';
        }
        $responce = [
            'status' => $status,
            'count' => App::call()->basketRepository->getCountWhere('sessionId', $sessionId),
            'id' => $id,
            'basketTotalPrice' => $basketTotalPrice
        ];
        echo json_encode($responce, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        die();
    }

    public function actionReduceItem()
    {
        $id = App::call()->request->params['id'];
        $sessionId = App::call()->session->getId();
        $basketItem = App::call()->basketRepository->getOne($id);
        $basketItemPrice = App::call()->productRepository->getProductPrice($basketItem->productId);


        if ($basketItem->quantity === 1 && $sessionId == $basketItem->sessionId) {
            App::call()->basketRepository->delete($basketItem);
        } else {
            $basketItem->quantity -= 1;
            App::call()->basketRepository->save($basketItem);
        }

        $status = 'ok';
        $quantity = $basketItem->quantity;
        $itemTotalPrice = $quantity * $basketItemPrice;
        $basket = App::call()->basketRepository->getBasket($sessionId);
        $basketTotalPrice = array_sum(array_column($basket, 'totalPrice'));
//        var_dump($basketItem, $quantity, $basketItemPrice);
//        die();
//        if (!$basketItem) {
//            $status = 'error not basket item';
//        } else {
//            $status = 'error HZ';
//        }
        $responce = [
            'status' => $status,
            'count' => App::call()->basketRepository->getCountWhere('sessionId', $sessionId),
            'quantity' => $quantity,
            'itemTotalPrice' => $itemTotalPrice,
            'basketTotalPrice' => $basketTotalPrice,
            'id' => $id
        ];
        echo json_encode($responce, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        die();
    }

    public function actionIncreaseItem()
    {
        $id = App::call()->request->params['id'];
        $sessionId = App::call()->session->getId();
        $userId = App::call()->session->userId;
        $basketItem = App::call()->basketRepository->getOne($id);

        $basketItem->quantity += 1;
        App::call()->basketRepository->save($basketItem);

        $status = 'ok';

        $basketItemPrice = App::call()->productRepository->getProductPrice($basketItem->productId);
        $quantity = $basketItem->quantity;
        $itemTotalPrice = $quantity * $basketItemPrice;
        $basket = App::call()->basketRepository->getBasket($sessionId);
        $basketTotalPrice = array_sum(array_column($basket, 'totalPrice'));

        $responce = [
            'status' => $status,
            'count' => App::call()->basketRepository->getCountWhere('sessionId', $sessionId),
            'quantity' => $quantity,
            'itemTotalPrice' => $itemTotalPrice,
            'basketTotalPrice' => $basketTotalPrice,
            'id' => $id
        ];
        echo json_encode($responce, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        die();
    }
}