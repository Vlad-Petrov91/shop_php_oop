<?php

namespace app\controllers;

use app\engine\App;
use app\engine\Session;
use app\models\entities\Basket;

class BasketController extends Controller
{

    public function actionIndex()
    {
        $session_id = (new Session())->getId();
        $basket = App::call()->basketRepository->getBasket($session_id);
        echo $this->render('basket/index', [
            'basket' => $basket
        ]);
    }

    public function actionAdd($params = [])
    {
        //$id = App::call()->request->params['id'];
        $id = $params['id'];
        $session_id = App::call()->session->getId();
        $basket = new Basket($session_id, $id);
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
        $session_id = (new Session())->getId();
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