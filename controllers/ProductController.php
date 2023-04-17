<?php

namespace app\controllers;

use app\engine\Request;
use app\models\repositories\ProductRepository;

class ProductController extends Controller
{
    public function actionCatalog()
    {
        $page = (new Request())->params['page'] ?? 0;
        //$catalog = Product::getAll();
        $catalog = (new ProductRepository())->getLimit(($page + 1) * 3);
        echo $this->render('catalog/index', [
            'catalog' => $catalog,
            'page' => ++$page
        ]);
    }

    public function actionCard()
    {
        // $id = $_GET['id'];
        //$id = (new Request())->__get('params')['id'];
        $id = (new Request())->params['id'];
        $product = (new ProductRepository())->getOne($id);
        echo $this->render('catalog/card', [
            'product' => $product
        ]);
    }
}