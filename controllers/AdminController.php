<?php

namespace app\controllers;

use app\engine\App;
use app\models\entities\Order;

class AdminController extends Controller
{
    public function actionIndex($params = [])
    {
        if (App::call()->userRepository->isAdmin()) {
            $page = $params['page'] ?? 0;
            $ordersList = App::call()->orderRepository->getLimit(($page + 1) * 3);

            echo $this->render('admin/index', [
                'ordersList' => $ordersList,
                'page' => ++$page
            ]);
        } else {
            echo '404';
        }

    }
}