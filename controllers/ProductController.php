<?php

namespace app\controllers;

use app\models\Product;

class ProductController extends Controller
{
    public function actionCatalog()
    {
        $page = $_GET['page'] ?: 0;

        //$catalog = Product::getAll();
        $catalog = Product::getLimit(($page + 1) * 3);
        echo $this->render('catalog/index', [
            'catalog' => $catalog,
            'page' => ++$page
        ]);
    }

    public function actionCard()
    {
        $id = $_GET['id'];
        $product = Product::getOne($id);
        echo $this->render('catalog/card', [
            'product' => $product
        ]);
    }
}